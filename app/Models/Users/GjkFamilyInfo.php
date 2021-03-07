<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Models\Users\GjkFamilyInfo
 *
 * @property int $id
 * @property int $gjk_user_id 贵健康用户ID
 * @property string $name 姓名
 * @property string|null $id_card 身份证
 * @property string|null $mobile 手机号
 * @property string $gender 性别
 * @property string|null $province 省份
 * @property string|null $city 城市
 * @property string|null $county 县区
 * @property string|null $address 详细地址
 * @property string|null $nation 民族
 * @property bool|null $family_id 关系ID
 * @property string|null $family_name 关系名称
 * @property string|null $birthday 生日
 * @property bool|null $auth_status 认证状态
 * @property string|null $auth_reason 认证意见
 * @property mixed|null $id_photo 证件照
 * @property string|null $avatar 头像
 * @property string $contacts_name 姓名
 * @property string|null $contacts_id_card 身份证
 * @property string|null $contacts_mobile 手机号
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|GjkFamilyInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GjkFamilyInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GjkFamilyInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|GjkFamilyInfo whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GjkFamilyInfo whereAuthReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GjkFamilyInfo whereAuthStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GjkFamilyInfo whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GjkFamilyInfo whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GjkFamilyInfo whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GjkFamilyInfo whereContactsIdCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GjkFamilyInfo whereContactsMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GjkFamilyInfo whereContactsName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GjkFamilyInfo whereCounty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GjkFamilyInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GjkFamilyInfo whereFamilyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GjkFamilyInfo whereFamilyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GjkFamilyInfo whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GjkFamilyInfo whereGjkUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GjkFamilyInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GjkFamilyInfo whereIdCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GjkFamilyInfo whereIdPhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GjkFamilyInfo whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GjkFamilyInfo whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GjkFamilyInfo whereNation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GjkFamilyInfo whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GjkFamilyInfo whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class GjkFamilyInfo extends Model
{
    use HasFactory;

    protected $connection = 'user';

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
