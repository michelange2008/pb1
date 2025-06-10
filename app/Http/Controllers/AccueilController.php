<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Espece;
use App\Models\Alerte;
use App\Models\Saisie;
use App\Models\Participant;
use App\Traits\CreeSaisie;
use App\Traits\EffaceElevages;
use App\Traits\LitJson;

class AccueilController extends Controller
{
    use CreeSaisie;
    use EffaceElevages;
    use LitJson;

    public function index()
    {
      return view('front');
    }

    public function accueil()
    {
      $saisies = Saisie::where('user_id', auth()->user()->id)
                  ->orderBy('created_at', 'desc')->get();

      $this->effaceElevages();

      $especes = Espece::all();
      session()->forget(['espece_id', 'theme', 'saisie', 'type_saisie']);

      return view('accueil', [
        "saisies" => $saisies,
        'especes' => $especes,
      ]);
    }

    public function instructions()
    {
      return view('divers.instructions');
    }

    public function description()
    {
      return view('divers.description');
    }

    public function credits()
    {
      $especes = Espece::all();
      $participants = Participant::all();

      return view('divers.credits', [
        'especes' => $especes,
        'participants' => $participants,
      ]);
    }

    public function contact()
    {
      return view('divers.contact');
    }

    public function mentions_legales()
    {
      return view('divers.mentions_legales', [
        'infos' => $this->litJson("mentions_legales.json"),
      ]);
    }

    public function aide()
    {
      return view('aide.aide');
    }

    public function video()
    {
      return view('divers.video', [
        'theme' => 'aide',
        'bouton' => 'retour',
        'route' => 'accueil',
      ]);
    }

}
