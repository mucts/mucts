<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGjkFamilyInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::connection('user')->hasTable('gjk_family_info')) {
            Schema::connection('user')->create('gjk_family_info', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('gjk_user_id')->comment('贵健康用户ID');
                $table->string('name', 32)->comment('姓名');
                $table->string('id_card', 18)->nullable()->comment('身份证');
                $table->string('mobile', 11)->nullable()->comment('手机号');
                $table->enum('gender', ['unknown', 'male', 'female', 'female_to_male', 'male_to_female', 'other'])->default('unknown')->comment('性别');
                $table->string('province', 32)->nullable()->comment('省份');
                $table->string('city', 32)->nullable()->comment('城市');
                $table->string('county', 32)->nullable()->comment('县区');
                $table->string('address', 300)->nullable()->comment('详细地址');
                $table->string('nation', 32)->nullable()->comment('民族');
                $table->unsignedTinyInteger('family_id')->nullable()->comment('关系ID');
                $table->string('family_name')->nullable()->comment('关系名称');
                $table->date('birthday')->nullable()->comment('生日');
                $table->unsignedTinyInteger('auth_status')->nullable()->comment('认证状态');
                $table->string('auth_reason', 100)->nullable()->comment('认证意见');
                $table->json('id_photo')->nullable()->comment('证件照');
                $table->string('avatar', 200)->nullable()->comment('头像');
                $table->string('contacts_name', 32)->comment('姓名');
                $table->string('contacts_id_card', 18)->nullable()->comment('身份证');
                $table->string('contacts_mobile', 11)->nullable()->comment('手机号');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('user')->dropIfExists('gjk_family_info');
    }
}
