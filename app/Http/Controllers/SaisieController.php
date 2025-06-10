<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Saisie;
use App\Models\Theme;
use App\Models\Alerte;
use App\Models\Salerte;
use App\Models\Sorigine;
use App\Models\Origine;
use App\Models\Elevage;
use App\Traits\CreeAlerte;

use Illuminate\Support\Facades\Redirect;
use App\Traits\CreeOrigines;
use App\Traits\CreeSaisie;
use App\Traits\SupprimePole;

class SaisieController extends Controller
{
    use CreeAlerte;
    use CreeSaisie;
    use CreeOrigines;
    use SupprimePole;

    /*
    // Méthode qui conduit vers une nouvelle saisie
    // elle redirige vers accueil
    */
    public function nouvelle($elevage_nom, $espece_id)
    {
      $elevage = Elevage::firstOrCreate(['nom' => $elevage_nom]);

      session()->put('espece_id', $espece_id);

      $this->nouvelleSaisie($elevage->id);

      return Redirect()->action('SaisieController@accueil');
    }

    /*
    // Méthode qui affiche le choix entre une saisie par alertes ou par pôle
    //quand on fait une nouvelle saisie ou que l'on modifie une ancienne
    */
    public function accueil()
    {
      $saisie = Saisie::find(session()->get('saisie_id'));

      return view('saisie.saisieAccueil', [
        'saisie' => $saisie,
      ]);
    }
    /*
    // Méthode appelée après le choix d'une nouvelle saisie
    // puis le choix d'un approche exhaustive ou par pôle (= $type)
    */
    public function saisie($type)
    {
      session()->forget('type_saisie');

      session()->put('type_saisie', $type);

      session()->forget('theme');

      $saisie = Saisie::find(session()->get('saisie_id'));
      // Trait pour ne prendre que les thèmes qui ont des alertes pour l'espèce concernée
      $themes = $this->supprimePole($saisie);

      if ($type == config('constantes.pol')) {
        return view('saisie.choixDuPole',[
          'themes' => $themes,
          'saisie' => $saisie,
        ]);
      }
      else {
        $alertes = Alerte::where('espece_id', $saisie->espece_id)->get();

        $sAlertes = Salerte::where('saisie_id', session()->get('saisie_id'))->get();

        return view('saisie.saisieParAlerte',[
            'saisie' => $saisie,
            'themes' => $themes,
            'alertes' => $alertes,
            'sAlertes' => $sAlertes,
          ]);
      }
    }

    /*
    // Méthode pour enregistrer la saisie correspondant aux alertes d'un thème
    // Elle valide la saisie
    // ELle enregistre en bdd les alertes
    // Elle renvoie une vue avec les alertes anormales pour pouvoir voir les questions correspondantes
    */
    public function enregistre(Request $request)
    {
      // si c'est une approche par pole, on ne prend que les alertes correspondant au pole (=theme) en cours
      if(session()->get('type_saisie') == config('constantes.pol')) {
        $alertes = Alerte::where('theme_id', session()->get('theme')->id)
        ->where('espece_id', session()->get('espece_id'))
        ->get();

        $themes[] = session()->get('theme');
      }
      else {
        $alertes = Alerte::where('espece_id', session()->get('espece_id'))->get();
        $themes = Theme::all();
      }
      $saisie = Saisie::find(session()->get('saisie_id'));
      // VALIDATION
      // après utilisation d'un middleware Sanitize qui transforme en 0 les null
      foreach ($alertes as $alerte) {

        if($alerte->type === "pourcentage")
        {
          $essai = request()->validate([
            'alerte_'.$alerte->id => 'numeric|between:0,100',
          ]);
        }
        elseif($alerte->type === "valeur")
        {
          $essai = request()->validate([
            'alerte_'.$alerte->id => 'numeric|min:0',
          ]);
        }
      }
      // en cas de modification d'une saisie déjà réalisée on récupère les id des origines pour pouvoir recocher les cases
      // En effet le trait CreeAlerte élimine toutes les alertes de la saisie
      $liste_origines = [];
      $ori = sOrigine::select('origine_id')->where('saisie_id', session()->get('saisie_id'))->get();
      foreach ($ori as $value) {
        $liste_origines[] = $value->origine_id;
      }

      $datas = array_slice($request->all(),1); // on enlève le token

      $resultats = $this->renvoieSalerte($datas, $alertes); // utilisation du trait CreeAlerte pour l'enregistrement de la saisie

      if($resultats->count() === 0) // aucune alerte anormale
      {
        $message = "Il n'y a aucun problème";
        if(session()->get('type_saisie') == config('constantes.ale'))
        {
          return view('saisie.resultatsGlobalOk', [
            'resultats' => $resultats,
            'saisie' => $saisie,
            ])->with(['message' => $message]);
        }
        else
        {
          return view('saisie.resultatsPoleOk', [
              'resultats' => $resultats,
              'saisie' => $saisie,
              'theme' => session()->get('theme'),
            ])->with(['message' => $message]);
        }
      }
        else // au moins une alerte anormale
        {
          return view('saisie.resultats', [
          'resultats' => $resultats,
          'themes' => $themes,
          'saisie' => $saisie,
          'liste_origines' => $liste_origines,
          ]);
        }
      }

      /*
      // Méthode qui ouvre la vue sur les alertes d'un thème dans le cadre d'une nouvelle saisie
      // ou de la modification d'une saisie existante
      */
      public function alertes($theme_id)
      {
        $theme = Theme::find($theme_id);

        session()->put('theme', $theme);

        $saisie = Saisie::find(session()->get('saisie_id'));

        $sAlertes = Salerte::where('saisie_id', session()->get('saisie_id'))->get();

        $alertes = Alerte::where('theme_id', $theme_id)
        ->where('espece_id', $saisie->espece->id)
        ->get();

        if($alertes->count() > 0)
        {
          return view('saisie.saisieParPole', [
            'saisie' => $saisie,
            'alertes' => $alertes,
            'sAlertes' => $sAlertes,
          ]);
        }
        else {
          session()->flash('message', "Il n'y a pas d'alerte pour ce pôle !");

          return back()->withInput();
        }
      }

    /*
    // Méthode pour modifier une saisie existante
    // Elle redirige vers accueil
    */
    public function modifier($saisie_id)
    {
      $saisie = Saisie::find($saisie_id);

      // Trait pour ne prendre que les thèmes qui ont des alertes pour l'espèce concernée

      $themes = $this->supprimePole($saisie);

      session()->put('espece_id', $saisie->espece->id);

      session()->put('type_saisie', config('constantes.pol'));

      session()->put('saisie_id', $saisie_id);

      return view('saisie.choixDuPole', [
        'themes' => $themes,
        'saisie' => $saisie,
      ]);
    }

    /*
    // Méthode pour enregistrer les origine d'une alerte anormale
    */
    public function storeOrigines(Request $request)
    {

        $this->creeOrigines(array_slice($request->all(),1));
        // si c'est une saisie par pôles on renvoie à la liste des pôles pour saisir le suivant
        if(session()->get('type_saisie') == config('constantes.pol')) {

          return view('saisie.choixDuPole', [
            'saisie' => Saisie::find(session()->get('saisie_id')),
            'themes' => Theme::all(),
          ]);
        }
        // Sinon c'est que c'est une saisie par alerte et on renvoie à la synthèse
        else {
          return redirect()->route('lecture.detail', session('saisie_id'));
        }
    }

}
