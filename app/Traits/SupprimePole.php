<?php
// Petit bricolage pour ne prendre que les thèmes qui ont des alertes pour l'espèce concernée
namespace App\Traits;

use App\Models\Alerte;
use App\Models\Theme;
/**
 *
 */
trait SupprimePole
{

  public function supprimePole($saisie)
  {
    $themes_utilises = Alerte::select('theme_id')->where('espece_id', $saisie->espece_id)->groupBy('theme_id')->get();

    foreach ($themes_utilises as $alerte) {
      $liste_themes_utilises[] = $alerte->theme_id;
    }
    $themes = Theme::find($liste_themes_utilises);

    return $themes;

  }


}
