<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	public function run()
	{
		Model::unguard();

		// $this->call('ThemeTableSeeder');
		// $this->command->info('Theme table seeded!');
		//
		// $this->call('EspeceTableSeeder');
		// $this->command->info('Espece table seeded!');

		// $this->call('AlerteTableSeeder');
		// $this->command->info('Alerte table seeded!');

// 		$this->call('OrigineTableSeeder');
// 		$this->command->info('Origine table seeded!');

		$this->call('ParticipantTableSeeder');
		$this->command->info('Participant table seeded!');

	}
}
