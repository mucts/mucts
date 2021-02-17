<?php

namespace App\Models\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Models\Users\RealNameInfo
 *
 * @property int $id
 * @property string $real_name 真实姓名
 * @property string $id_card 身份证号
 * @property string|null $bank_card 认证银行卡号
 * @property string|null $mobile 认证联系手机号
 * @property string $auth_channel 认证渠道：def-默认，gjk_work-家庭医生工作站，lm_back-朗玛移动（回调） lm_api-朗玛移动（接口调用） gz_pl-省平台银行卡验证 gy_ly-六医体检中心
 * @property string $authed_at 认证时间
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|RealNameInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RealNameInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RealNameInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|RealNameInfo whereAuthChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RealNameInfo whereAuthedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RealNameInfo whereBankCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RealNameInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RealNameInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RealNameInfo whereIdCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RealNameInfo whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RealNameInfo whereRealName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RealNameInfo whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RealNameInfo extends Model
{
    use HasFactory;

    protected $connection = 'user';

    public const AUTH_CHANNEL_DEF      = 'def';
    public const AUTH_CHANNEL_GJK_WORK = 'gjk_work';
    public const AUTH_CHANNEL_LM_BACK  = 'lm_back';
    public const AUTH_CHANNEL_LM_API   = 'lm_api';
    public const AUTH_CHANNEL_GZ_PL    = 'gz_pl';
    public const AUTH_CHANNEL_GY_LY    = 'gy_ly';

    public const AUTH_CHANNEL = [
        self::AUTH_CHANNEL_DEF      => "默认",
        self::AUTH_CHANNEL_GJK_WORK => "家庭医生工作站",
        self::AUTH_CHANNEL_LM_BACK  => "朗玛移动（回调）",
        self::AUTH_CHANNEL_LM_API   => "朗玛移动（接口调用）",
        self::AUTH_CHANNEL_GZ_PL    => "省平台银行卡验证",
        self::AUTH_CHANNEL_GY_LY    => "六医体检中心"
    ];

    protected $casts = [];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];
}
