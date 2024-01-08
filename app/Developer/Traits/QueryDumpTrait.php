<?php


namespace App\Developer\Traits;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait QueryDumpTrait
{
    private static function dumpQueryDetails()
    {
        //only test in debug mode for now
        //don't do in production
        if (env('LOG_HEAVY_QUERIES')){
            DB::listen(function ($query) {
                $timeInMs = $query->time;
                $timeInS = $timeInMs/1000;
                $channel = 'query';
                if($timeInS >=10){
                    $channel = 'heavy-query';
                }
                logDetails($channel,['query' => $query->sql,'bindings' => $query->bindings,'time' => $timeInMs .'ms '. $timeInS .'s']);
                logDetails($channel,PHP_EOL.PHP_EOL.PHP_EOL .'------------------------------------------------'.PHP_EOL.PHP_EOL.PHP_EOL);
            });
        }
    }
}
