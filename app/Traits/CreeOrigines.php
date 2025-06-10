<?php
namespace App\Traits;

use App\Models\Sorigine;

trait CreeOrigines
{

    public function CreeOrigines($origines)
    {

        foreach ($origines as $alerte_origine => $value)
        {
            $sorigine = new Sorigine();
            $sorigine->origine_id = explode("_", $alerte_origine)[1];
            $sorigine->salerte_id = explode("_", $alerte_origine)[0];
            $sorigine->saisie_id = session()->get('saisie_id');

            if(Sorigine::where('origine_id', explode("_", $alerte_origine)[1])
                        ->where('salerte_id', explode("_", $alerte_origine)[0])
                        ->where('saisie_id', session()->get('saisie_id'))
                        ->count() === 0)
            {
                $sorigine->save();
            }
        }
    }
}
