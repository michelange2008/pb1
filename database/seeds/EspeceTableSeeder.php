<?php

use Illuminate\Database\Seeder;
use App\Models\Espece;

class EspeceTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('especes')->delete();

		// VA
		Espece::create(array(
				'nom' => 'vaches allaitantes',
				'icone' => 'VA.svg'
			));

		// VL
		Espece::create(array(
				'nom' => 'vaches laitières',
				'icone' => 'VL.svg'
			));

		// CP
		Espece::create(array(
				'nom' => 'caprins',
				'icone' => 'CP.svg'
			));

		// OA
		Espece::create(array(
				'nom' => 'brebis allaitantes',
				'icone' => 'OA.svg'
			));

		// OL
		Espece::create(array(
				'nom' => 'brebis laitières',
				'icone' => 'OL.svg'
			));
	}
}