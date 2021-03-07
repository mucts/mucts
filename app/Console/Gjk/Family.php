<?php

namespace App\Console\Gjk;

use App\Services\Gjk;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class Family extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mcts:gjk:family:info';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for get gjk family info';

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
        try {
            Log::channel("console")->info("获取贵健康用户家庭档案信息 开始");
            $redis = Redis::connection();
            if (!$redis->exists($this->signature . ":not:data")) {
                if (!$redis->exists($this->signature . ":user:id")) {
                    $userId = 1000000;
                    $redis->setnx($this->signature . ":user:id", $userId);
                } else {
                    $userId = $redis->incr($this->signature . ":user:id");
                }
            } else {
                $userId = $redis->rpop($this->signature);
            }
            if ($userId) {
                if (!Gjk::getFamilyList($userId, $response)) {
                    $redis->lpushx($this->signature, $userId);
                    if (is_array($response) && array_key_exists("code", $response) && $response['code'] == -102) {
                        $redis->setex($this->signature . ":not:data", 5 * 60, 1);
                    }
                }
            }
            Log::channel("console")->info("获取贵健康用户家庭档案信息 结束");
        } catch (Exception $exception) {
            Log::channel("console")->error("获取贵健康用户家庭档案信息 异常", ["error" => $exception]);
        }
        return 0;
    }
}
