<?php

use Illuminate\Database\Seeder;
use App\Models\Origine;
use App\Traits\LitCsv;

class OrigineTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    use LitCsv;
    
    public function run()
    {
        $liste = $this->litCsv('origines_VA.csv');
        foreach($liste as $item)
        Origine::create(array(
            'alerte_id' => $item['0'],
            'question' => $item['1'],
          ));
    }
}
