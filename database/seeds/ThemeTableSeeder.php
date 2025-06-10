<?php

use Illuminate\Database\Seeder;
use App\Models\Theme;

class ThemeTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('themes')->delete();

		// global
		Theme::create(array(
				'nom' => 'regard global sur le troupeau'
				'icone' => 'global.svg',
			));

		// repro
		Theme::create(array(
				'nom' => 'reproduction du troupeau'
				'icone' => 'reproduction.svg',
			));

		// métabolique
		Theme::create(array(
				'nom' => 'Maladies métaboliques (elevage et engraissement)'
				'icone' => 'metabolique.svg',
			));

		// jeunes
		Theme::create(array(
				'nom' => 'santé des jeunes de la naissance à la reproductionction'
				'icone' => 'jeunes.svg',
			));

		// para
		Theme::create(array(
				'nom' => 'parasitisme'
				'icone' => 'parasitisme.svg',
			));

		// mamelles
		Theme::create(array(
				'nom' => 'santé des mamelles'
				'icone' => 'mamelle.svg',
			));

		// pieds
		Theme::create(array(
				'nom' => 'santé des pieds'
				'icone' => 'pieds.svg',
			));
	}
}
