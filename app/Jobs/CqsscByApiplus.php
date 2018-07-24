<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Redis;

class CqsscByApiplus implements ShouldQueue
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
        $url = 'http://f.apiplus.cn/newly.do?code=cqssc&format=json';
        $url .= (strpos($url, '?') > 0 ? '&' : '?') . '_=' . time();

        $info = file_get_contents($url);
        $res  = json_decode($info, true);

        if ($res) {
            if (isset($res['data'])) {
                $data = array_reverse($res['data']);
                foreach ($data as $k => $v) {
                    $key = 'cqssc.code:' . substr($v['expect'], 0, 8);
                    $expireat = strtotime(date('Y-m-d',strtotime('+1 day'))) + 600;
                    Redis::hset($key, $v['expect'], $v['opencode']);
                    Redis::expireat($key, $expireat);
                }
            }
        }
    }
}
