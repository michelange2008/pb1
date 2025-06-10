<?php

use Illuminate\Database\Seeder;
use App\Models\Alerte;
use App\Traits\LitCsv;

class AlerteTableSeeder extends Seeder {

    use LitCsv;
    
	public function run()
	{
// 		DB::table('alertes')->delete();

        $liste = $this->litCsv("alertes_VA.csv"); 
//         dd($liste);
        foreach($liste as $item){
            dump($item);
    		Alerte::create([
        		'nom' => $item[0],
    		    'type' => $item[1],
    		    'unite' => $item[2],
    		    'niveau' => $item[3],
    		    'modalites' => "", 
                'theme_id' => $item[4],
                'espece_id' => $item[5]
    		]);
        }
    }
}
