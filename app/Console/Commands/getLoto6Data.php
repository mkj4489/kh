<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;

class getLoto6Data extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'getloto6';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ロト６の当選番号を取得する';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //

	system("wget http://loto6.thekyo.jp/data/loto6.csv");
	system("mv loto6.csv storage/");

	$csv_file = 'loto6.csv';
	$csv_file_path = 'storage/' . $csv_file;
	$table = 'loto6data';

	if(!file_exists($csv_file_path)){
		echo "no csvdata files!";
		exit;
	}else{
		DB::statement('TRUNCATE TABLE '.$table);
		$fp = fopen($csv_file_path, 'rb');
		$cnt = 0;
        	while ($row = fgetcsv($fp)) {
			if($cnt == 0){
				$cnt++;
				continue;
			}
			print_r($row);
			$insert_data = '\'' . implode('\',\'', $row) . '\' ,NOW()';
			DB::insert('insert into '.$table.' values ('.$insert_data.')');
		}
	}
    }
}
