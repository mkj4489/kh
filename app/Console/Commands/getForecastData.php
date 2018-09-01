<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use DB;

class getForecastData extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'getforecast';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = '予想データを取得する';

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
		for($number=1; $number<=43; $number++){
			$insert_data = array();
			$insert_data[] = $id;
			$insert_data[] = $number;
			$case1 = $this->getForecastCase1($number);
			echo "case1 " . $case1;
			$insert_data[] = $case1;
			$case2 = $this->getForecastCase2($number);
			echo "case2 " . $case2;
			$insert_data[] = $case2;
			$case3 = $this->getForecastCase3($number);
			echo "case3 " . $case3;
			$insert_data[] = $case3;
			$case4 = $this->getForecastCase4($number,$case3);
			echo "case4 " . $case4;
			$insert_data[] = $case4;
			$case5 = $this->getForecastCase5($number);
			echo "case5 " . $case5;
			$insert_data[] = $case5;
			$case6 = $this->getForecastCase6($number,$case5);
			echo "case6 " . $case6;
			$insert_data[] = $case6;
			$case7 = $this->getForecastCase7($number);
			echo "case7 " . $case7;
			$insert_data[] = $case7;

			$sum = $case1 * 10 + $case2 *10 + $case4 + $case6;
			echo $sum;
			$now = date('Y-m-d H:i:s');
			//$insert_data_str = '\'' . implode('\',\'', $insert_data) . '\' ,NOW()';
			DB::insert('insert into '.$insert_table.' (id,number,sum,case1,case2,case3,case4,case5,case6,case7,inst_date) values ("'.$id.'","'.$number.'","'.$sum.'","'.$case1.'","'.$case2.'","'.$case3.'","'.$case4.'","'.$case5.'","'.$case6.'","'.$case7.'","'.$now.'")');
		}
	}

	/**
	 * 前回出ている数字かどうか
	 * @param $number
	 * @return 
	 */
	public function getForecastCase1($number){

		//最新の当選番号を取得
		$loto6data = DB::select(DB::raw('select * from LOTO6DATA order by id desc limit 1'));
		$loto6data = json_encode($loto6data);
		$loto6data = json_decode($loto6data,true);
		//print_r($loto6data);
		$isOK = 0;
		foreach($loto6data as $data){
			if($data['no1'] == $number){
				$isOK = 1;
			}
			if($data['no2'] == $number){
				$isOK = 1;
			}
			if($data['no3'] == $number){
				$isOK = 1;
			}
			if($data['no4'] == $number){
				$isOK = 1;
			}
			if($data['no5'] == $number){
				$isOK = 1;
			}
			if($data['no6'] == $number){
				$isOK = 1;
			}
			if($data['bonus'] == $number){
				$isOK = 1;
			}
		}
		return $isOK;
	}

	/**
	 * 前々回数字に出ているか
	 * @param $number
	 * @return 
	 */
	public function getForecastCase2($number){

		//最新の当選番号を取得
		$loto6data = DB::select(DB::raw('select * from LOTO6DATA order by id desc limit 2'));
		$loto6data = json_encode($loto6data);
		$loto6data = json_decode($loto6data,true);
		//print_r($loto6data);
		$isOK = 0;
		if($loto6data[1]['no1'] == $number){
			$isOK = 1;
		}
		if($loto6data[1]['no2'] == $number){
			$isOK = 1;
		}
		if($loto6data[1]['no3'] == $number){
			$isOK = 1;
		}
		if($loto6data[1]['no4'] == $number){
			$isOK = 1;
		}
		if($loto6data[1]['no5'] == $number){
			$isOK = 1;
		}
		if($loto6data[1]['no6'] == $number){
			$isOK = 1;
		}
		if($loto6data[1]['bonus'] == $number){
			$isOK = 1;
		}
		return $isOK;
	}

	/**
	 * 今までの当選番号で、何回出現しているか
	 * @param $number
	 * @return 
	 */
	public function getForecastCase3($number){

		//最新の当選番号を取得
		$loto6data = DB::select(DB::raw('select * from LOTO6DATA order by id desc'));
		$loto6data = json_encode($loto6data);
		$loto6data = json_decode($loto6data,true);
		//print_r($loto6data);
		$count = 0;
		foreach($loto6data as $i => $data){
			if($loto6data[$i]['no1'] == $number){
				$count++;
			}
			if($loto6data[$i]['no2'] == $number){
				$count++;
			}
			if($loto6data[$i]['no3'] == $number){
				$count++;
			}
			if($loto6data[$i]['no4'] == $number){
				$count++;
			}
			if($loto6data[$i]['no5'] == $number){
				$count++;
			}
			if($loto6data[$i]['no6'] == $number){
				$count++;
			}
			if($loto6data[$i]['bonus'] == $number){
				$count++;
			}
		}
		return $count;
	}

	/**
	 * 平均何回に１回出ているか
	 * @param $number
	 * @param $count
	 * @return TODO returnする数が小さくなりすぎる
	 */
	public function getForecastCase4($number,$count){

		//最新の当選番号を取得
		$loto6data = DB::select(DB::raw('select * from LOTO6DATA order by id desc limit 1'));
		$loto6data = json_encode($loto6data);
		$loto6data = json_decode($loto6data,true);
		//print_r($loto6data);
		$id = $loto6data[0]['id']; //すべてのロト6の開催回数
		$result = $count / $id;
		$result = $result * 100;
		return (int)$result;
	}

	/**
	 * 過去50回の出現回数
	 * @param $number
	 * @return 
	 */
	public function getForecastCase5($number){

		//最新の当選番号を取得
		$loto6data = DB::select(DB::raw('select * from LOTO6DATA order by id desc limit 100'));
		$loto6data = json_encode($loto6data);
		$loto6data = json_decode($loto6data,true);
		//print_r($loto6data);
		$count = 0;
		foreach($loto6data as $i => $data){
			if($loto6data[$i]['no1'] == $number){
				$count++;
			}
			if($loto6data[$i]['no2'] == $number){
				$count++;
			}
			if($loto6data[$i]['no3'] == $number){
				$count++;
			}
			if($loto6data[$i]['no4'] == $number){
				$count++;
			}
			if($loto6data[$i]['no5'] == $number){
				$count++;
			}
			if($loto6data[$i]['no6'] == $number){
				$count++;
			}
			if($loto6data[$i]['bonus'] == $number){
				$count++;
			}
		}
		return $count;
	}

	/**
	 * 過去50回の短期出現率 平均何回に１回出ているか
	 * @param $number
	 * @return  TODO returnする数が小さくなりすぎる
	 */
	public function getForecastCase6($number,$count){

		$result = $count / 100;
		$result = $result * 100;
		return (int)$result;
	}

	/**
	 * 最近10回で何回出たか
	 * @param $number
	 * @return 
	 */
	public function getForecastCase7($number){

		//最新の当選番号を取得
		$loto6data = DB::select(DB::raw('select * from LOTO6DATA order by id desc limit 100'));
		$loto6data = json_encode($loto6data);
		$loto6data = json_decode($loto6data,true);
		//print_r($loto6data);
		$count = 0;
		foreach($loto6data as $i => $data){
			if($loto6data[$i]['no1'] == $number){
				$count++;
			}
			if($loto6data[$i]['no2'] == $number){
				$count++;
			}
			if($loto6data[$i]['no3'] == $number){
				$count++;
			}
			if($loto6data[$i]['no4'] == $number){
				$count++;
			}
			if($loto6data[$i]['no5'] == $number){
				$count++;
			}
			if($loto6data[$i]['no6'] == $number){
				$count++;
			}
			if($loto6data[$i]['bonus'] == $number){
				$count++;
			}
		}
		return $count;
	}
}
