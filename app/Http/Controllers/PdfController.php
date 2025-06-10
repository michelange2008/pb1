<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Saisie;
use App\Models\Theme;
use App\Models\Categorie;
use PDF;

class PdfController extends Controller
{


    public function index($saisie_id)
    {
      $saisie = Saisie::findOrFail($saisie_id);
      $pdf = PDF::loadView('lecture.pdfSaisie', [
        'saisie' => $saisie,
        'themes' => Theme::all(),
        'categories' => Categorie::all(),
      ]);
      $nomFichier = $saisie->elevage->nom."_".$saisie->espece->nom."_".$saisie->updated_at.".pdf";

      return $pdf->stream($nomFichier);

    }
}
