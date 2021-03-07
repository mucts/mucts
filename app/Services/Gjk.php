<?php

namespace App\Services;

use App\Models\Users\GjkFamilyInfo;
use App\Models\Users\RealNameInfo;

class Gjk
{
    /**
     * 拉取家庭档案信息
     * @param int $userId
     * @param $response
     * @return bool
     * @author herry.yao<yao.yuandeng@qianka.com>
     */
    public static function getFamilyList(int $userId, &$response): bool
    {
        $response = gjk_request("/registration/patient/list", ["user_id" => $userId]);
        if (self::_authCode($response) && array_key_exists("list", $response) && is_array(($list = $response['list']))) {
            foreach ($list as $item) {
                if ($item['status'] == 6) {
                    $real = RealNameInfo::whereIdCard($item['patient_id_no'])->first();
                    if ($real) {
                        if (!$real->mobile) {
                            $real->mobile = $item['patient_phone'];
                            $real->save();
                        }
                    } else {
                        RealNameInfo::query()->updateOrCreate(
                            [
                                "id_card" => $item['patient_id_no']
                            ],
                            [
                                "id_card"      => $item['patient_id_no'],
                                "real_name"    => $item['patient_name'],
                                "auth_channel" => RealNameInfo::AUTH_CHANNEL_LM_BACK,
                                "mobile"       => $item['patient_phone'],
                                "authed_at"    => current_datetime()
                            ]
                        );
                    }
                }
                if (id_card_verify($item['patient_id_no']) || id_card_verify($item['contacts_id_no'])) {
                    list($province, $city, $county) = explode("_", $item['province_city_zone'] . "___");
                    GjkFamilyInfo::query()->updateOrCreate(
                        [
                            "gjk_user_id" => $userId,
                            "id_card"     => $item['patient_id_no']
                        ],
                        [
                            "gjk_user_id"      => $userId,
                            "id_card"          => $item['patient_id_no'],
                            "name"             => $item['patient_name'],
                            "mobile"           => $item['patient_phone'],
                            "gender"           => $item['gender'] == 0 ? 'male' : 'female',
                            "province"         => $province,
                            "city"             => $city,
                            "county"           => $county,
                            "address"          => $item['patient_addr'],
                            "nation"           => $item['nation'],
                            "family_id"        => $item['family_rel_id'],
                            "family_name"      => $item['family_rel_name'],
                            "birthday"         => $item['birthday'] === "0000-00-00" ? ($item['patient_id_no'] ? substr($item['patient_id_no'], 6, 8) : null) : $item['birthday'],
                            "auth_status"      => $item['status'],
                            "auth_reason"      => $item['reason'],
                            "id_photo"         => json_encode($item['id_photo']),
                            "avatar"           => $item['patient_avatar'],
                            "contacts_name"    => $item['contacts_name'],
                            "contacts_id_card" => $item['contacts_id_no'],
                            "contacts_mobile"  => $item['contacts_phone']
                        ]
                    );
                }
            }
            return true;
        }
        return false;
    }

    /**
     * get gjk real name info
     * @param int $userId
     * @param $response
     * @return bool
     */
    public static function getRealName(int $userId, &$response): bool
    {
        $response = gjk_request("/common/user/realname/info", ["user_id" => $userId]);
        if (self::_authCode($response) && array_key_exists("info", $response) && is_array(($info = $response['info'])) && array_key_exists("is_real_name", $info) && $info['is_real_name'] == 1) {
            $real = RealNameInfo::whereIdCard($info['id_card'])->first();
            if ($real) {
                $real->bank_card = $info['bank_card'];
                $real->mobile    = $info['phone_num'];
                $real->save();
            } else {
                $real = RealNameInfo::query()->updateOrCreate(
                    [
                        "id_card" => $info['id_card']
                    ],
                    [
                        "id_card"      => $info['id_card'],
                        "real_name"    => $info['real_name'],
                        "auth_channel" => RealNameInfo::AUTH_CHANNEL_GZ_PL,
                        "mobile"       => $info['phone_num'],
                        "bank_card"    => $info['bank_card'],
                        "authed_at"    => current_datetime()
                    ]
                );
            }
            return $real ? true : false;
        }
        return false;
    }

    /**
     * 校验状态码
     * @param $response
     * @return bool
     * @author herry.yao<yao.yuandeng@qianka.com>
     */
    private static function _authCode(&$response): bool
    {
        $response = is_array($response) ? $response : json_decode($response, true);
        return is_array($response) && array_key_exists("code", $response) && ($response['code'] === 0 || $response['code'] === "0");
    }
}
