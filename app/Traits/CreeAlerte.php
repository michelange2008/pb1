<?php
namespace App\Traits;

use App\Models\Alerte;
use App\Models\Salerte;
/**
 *
 */
trait CreeAlerte
{
  function renvoieSalerte($datas, $alertes)
  {

    $resultats = collect();

    foreach ($alertes as $alerte) {

      Salerte::where('alerte_id', $alerte->id)->where('saisie_id', session()->get('saisie_id'))->delete(); // éliminer les alertes saisies antérieurement pour le theme en cours
      $probleme = false;
      if($alerte->modalites === "inverse" && $datas['alerte_'.$alerte->id] < $alerte->niveau) //cas d'une modalité inverse où la valeur observée doit être supérieure à un seuil (ex: % de vaches pleines)
      {
          $probleme = true;
      }
      elseif($alerte->modalites !== "inverse" && $datas['alerte_'.$alerte->id] > $alerte->niveau)  // cas d'une modalité où la valeur observée doit être inférieurs à un seuil (cas le plus fréquent: exemple: taux de mortalité)
      {
          $probleme = true;
      }
      if($probleme)
      {
            $sAlerte = new Salerte();
            $sAlerte->saisie_id = session()->get('saisie_id');
            $sAlerte->alerte_id = $alerte->id;
            $sAlerte->valeur = $datas['alerte_'.$alerte->id];
            $sAlerte->danger = 1;

            if(Salerte::where('saisie_id', session()->get('saisie_id'))->where('alerte_id', $alerte->id)->count() === 0)
            {
                $sAlerte->save();
            }
            $sAlerte = Salerte::where('saisie_id', session()->get('saisie_id'))->where('alerte_id', $alerte->id)->first();
            $resultats->push($sAlerte);
      }
    }

    return $resultats;

  }

}
