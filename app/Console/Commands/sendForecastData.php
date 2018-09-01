<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use DB;

class sendForecastData extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'sendforecast';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = '$BM=A[%G!<%?$r<hF@$9$k(B';

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
		$insert_table = 'LOTO6FORECASTDATA';
		$id = 1;
		$loto6data = $this->getForecastData($id);
		$this->sendForecastData($loto6data);

	}

	/**
	 * $BA02s=P$F$$$k?t;z$+$I$&$+(B
	 * @param $number
	 * @return 
	 */
	public function getForecastData($id){

		//$B:G?7$NEvA*HV9f$r<hF@(B
		$loto6data = DB::select(DB::raw('select * from LOTO6FORECASTDATA where id =' . $id . ' order by sum DESC limit 6'));
		$loto6data = json_encode($loto6data);
		$loto6data = json_decode($loto6data,true);
		print_r($loto6data);

		return $loto6data;
	}

	/**
	 * $BA0!92s?t;z$K=P$F$$$k$+(B
	 * @param $number
	 * @return 
	 */
	public function sendForecastData($loto6data){

		mb_language("Japanese");
		mb_internal_encoding("UTF-8");

		$to      = 'loto6@uchouten.sakura.ne.jp';
		$subject = '次回のロト６予想';
		$message = <<<MAIL
次回のロト６の予想は、
{$loto6data[0]['number']}
{$loto6data[1]['number']}
{$loto6data[2]['number']}
{$loto6data[3]['number']}
{$loto6data[4]['number']}
{$loto6data[5]['number']}
MAIL;
		$headers = 'From: masakijo@gmail.com' . "\r\n";
echo $message;
		mb_send_mail($to, $subject, $message, $headers);

	}

}
