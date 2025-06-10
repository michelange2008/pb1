<?php
namespace App\Rep;

use Flynsarmy\CsvSeeder\CsvSeeder;

class CsvAlerteSeeder extends CsvSeeder {

	public function __construct()
	{
    $this->table = 'origines';
		$this->filename = base_path().'/public/alerteCSV.csv';
    $this->csv_delimiter = ';';
    $this->mapping = [
      0 => "alerte_id",
      1 => "question"
    ];
	}

	public function run()
	{
		// Recommended when importing larger CSVs
		// DB::disableQueryLog();

		// Uncomment the below to wipe the table clean before populating
		// DB::table($this->table)->truncate();

		parent::run();
	}
}
