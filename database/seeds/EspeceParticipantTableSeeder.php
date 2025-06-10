<?php

use Illuminate\Database\Seeder;

class EspeceParticipantTableSeeder extends Seeder
{
  use LitCsv;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $liste = $this->litCsv("participants_liste.csv");

      foreach($liste as $item){
      Participant::create([
          'nom' => $item[0],
          'institution' => $item[1],
      ]);
      }
    }
}
