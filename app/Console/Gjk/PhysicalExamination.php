<?php

namespace App\Console\Gjk;

use App\Models\Users\RealNameInfo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class PhysicalExamination extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mcts:gjk:physical:examination';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
        try {
            Log::channel("console")->info("拉取体检报告 开始");
            $url = "http://58.42.241.104:1025/api/physicalExamReportList";
            $res = api_request($url, "post", [
                "report_start_time" => get_datetime(),
                "report_end_time"   => current_datetime()
            ], [], "json", 600);
            if ($res && ($res = json_decode($res, true))
                && is_array($res)
                && array_key_exists("code", $res)
                && ($res['code'] === 0 || $res['code'] === '0')
                && array_key_exists("PEPatientsList", $res)
                && ($list = $res['PEPatientsList'])
                && is_array($list)) {
                foreach ($list as $item) {
                    if (array_key_exists("id_card", $item)
                        && array_key_exists("name", $item)
                        && !preg_match("/测试/", $item['name'])
                        && id_card_verify($item['id_card'])) {
                        $info = RealNameInfo::whereidCard($item['id_card'])->first();
                        if ($info && array_key_exists("phone", $item) && $item['phone'] && preg_match('/^1\d{10}$/', $item['phone']) && !$info->mobile) {
                            $info->mobile = $item['phone'];
                            $info->save();
                        } else {
                            RealNameInfo::query()->updateOrCreate(
                                [
                                    "id_card" => $item['id_card']
                                ],
                                [
                                    "id_card"      => $item['id_card'],
                                    "real_name"    => $item['name'],
                                    "auth_channel" => RealNameInfo::AUTH_CHANNEL_GY_LY,
                                    "mobile"       => @$item['phone'] && strlen($item['phone']) == 11 ? $item['phone'] : null,
                                    "authed_at"    => current_datetime()
                                ]
                            );
                        }
                    }
                }
            }
            Log::channel("console")->info("拉取体检报告 结束");
        } catch (\Exception $exception) {
            Log::channel("console")->error("拉取体检报告 异常", ["error" => $exception]);
        }
        return 0;
    }
}
