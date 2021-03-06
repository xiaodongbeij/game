<?php

namespace App\Console\Commands;

use App\Jobs\Lottery;
use App\Models\LotteryRecord;
use Illuminate\Console\Command;

class ssc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'open:ssc {lottery=3}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '一分时时彩';

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
     * @return int
     */
    public function handle()
    {
        $id = $this->argument('lottery');
        $code = rand(0,9) . ',' . rand(0,9) . ',' . rand(0,9) . ',' . rand(0,9) . ',' . rand(0,9);
        $lottery_record = LotteryRecord::where('lottery_time','<=',time())->where('lottery_id',$id)->orderby('id','desc')->first();
        // $lottery_record = LotteryRecord::where('issue','202106071099')->where('lottery_id',1)->orderby('id','desc')->first();
        if(!$lottery_record->code)
        {
            $lottery_record->code = $code;
            $lottery_record->save();
        }

        Lottery::dispatch($lottery_record);
        echo "彩种:一分时时彩 - 期号：{$lottery_record->issue} - 开奖号码: {$lottery_record->code} \n";
    }
}
