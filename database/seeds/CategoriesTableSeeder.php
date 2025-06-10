<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $table = [
        'alimentation',
        'logement',
        'hygiène',
        'conduite',
        'santé',
        'génétique',
        'divers',
        'parasitisme',
      ];
      $i = 1;
      foreach ($table as $value) {
        DB::table('categories')->insert([
            'id' => $i,
            'nom' => $value,
        ]);
        $i++;
      }
    }
}
