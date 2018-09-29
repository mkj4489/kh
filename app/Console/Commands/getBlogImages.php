<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;

class getBlogImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'getblogimages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ブログの画像を取得するバッチ';

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

        define('URL', 'http://www.keyakizaka46.com/s/k46o/diary/member/list?ima=0000&ct=');
        for($i=1; $i<=42; $i++){
            if($i<10){
                $i = '0' . $i;
            }
            $geturl = URL . $i;
            $blog = file_get_contents($geturl);
            echo $blog;
        }
        //$insert_data = '\'' . implode('\',\'', $row) . '\' ,NOW()';
        //DB::insert('insert into '.$table.' values ('.$insert_data.')');
    }
}
