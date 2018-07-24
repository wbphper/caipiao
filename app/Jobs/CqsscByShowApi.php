<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Redis;

class CqsscByShowApi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $showapi_appid  = env('SHOWAPI_APPID');
        $showapi_secret = env('SHOWAPI_SECRET');
        $paramArr       = [
            'showapi_appid' => $showapi_appid,
            'code'          => 'cqssc'
        ];

        $paraStr = '';
        $signStr = '';
        ksort($paramArr);
        foreach ($paramArr as $key => $val) {
            if ($key != '' && $val != '') {
                $signStr .= $key . $val;
                $paraStr .= $key . '=' . urlencode($val) . '&';
            }
        }
        $signStr .= $showapi_secret;
        $sign     = strtolower(md5($signStr));
        $paraStr .= 'showapi_sign=' . $sign;

        $param = $paraStr;
        $url   = env('SHOWAPI_URL') . '?' . $param;
        $info  = file_get_contents($url);
        if ($info) {
            $res = json_decode($info, true);
            $result = $res['showapi_res_body']['result'][0];

            $key = 'cqssc.code:' . substr($result['expect'], 0, 8);
            $expireat = strtotime(date('Y-m-d',strtotime('+1 day'))) + 600;
            Redis::hset($key, $result['expect'], $result['openCode']);
            Redis::expireat($key, $expireat);
        }
    }
}
