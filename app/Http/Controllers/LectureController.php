<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Saisie;
use App\Models\Theme;
use App\Models\Salerte;
use App\Models\Sorigine;
use App\Models\Elevage;
use App\Models\Espece;
use App\Models\Categorie;

use App\Traits\SupprimePole;

class LectureController extends Controller
{

    use SupprimePole;

    public function detail($saisie_id) {

        session()->put('saisie_id', $saisie_id);

        $saisie = Saisie::find($saisie_id);

        //Utilisation du trait supprimePole pour ne prendre que les thèmes de l'espèce
        $themes = $this->supprimePole($saisie);

        return view('lecture.detail', [
            'saisie' => $saisie,
            'themes' => $themes,
        ]);
    }
    public function supprimer($saisie_id)
    {
      session()->put('saisie_id', $saisie_id);

      $elevage = Saisie::where('id', $saisie_id)->first()->elevage_id;

      $effacerElevage = false;

      if(Saisie::where('elevage_id', $elevage)->count() === 1)
      {
        $effacerElevage = true;
      }

      Saisie::destroy($saisie_id);

      if($effacerElevage) Elevage::destroy($elevage);

      return redirect()->back();
    }

    public function observations($salerte_id)
    {
      $tableNomOrigines = [];

      foreach(Sorigine::where('salerte_id', $salerte_id)->get() as $sorigine)
      {
          $tableNomOrigines[] = ucfirst($sorigine->origine->reponse);
      }

      return response()->json($tableNomOrigines, 200);
    }

    public function originesListe($saisie_id)
    {
      session()->put('saisie_id', $saisie_id);

      $saisie = Saisie::find($saisie_id);

      $sorigines = Sorigine::where('saisie_id', $saisie_id)->get();

      // s'il n'y a aucune alerte
      if($sorigines->count() == 0) {
        $message = "Il n'y a aucun problème signalé";
        return view('saisie.resultatsGlobalOk', ['saisie' => $saisie])->with(['message' => $message]);
      }

      // on recherche la liste des catégories dans le sorigines
      foreach ($sorigines as $sorigine) {
        $cat[] = $sorigine->origine->categorie_id;
      }
      // on élimine les doublons de cette liste
      collect($cat)->unique();

      // et on recherche les objets catégories de cette liste
      $categories = Categorie::whereIn('id', collect($cat)->unique())->get();
      return view('lecture.originesListe', [
        'sorigines' => $sorigines,
        'saisie' => $saisie,
        'categories' => $categories,
      ]);
    }
}
