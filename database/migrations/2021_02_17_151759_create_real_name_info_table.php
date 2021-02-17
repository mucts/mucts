<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRealNameInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('user')->hasTable('real_name_info')) {
            Schema::connection('user')->create('real_name_info', function (Blueprint $table) {
                $table->id();
                $table->string('real_name', 32)->comment('真实姓名');
                $table->char('id_card', 18)->unique('idx_id_card')->comment('身份证号');
                $table->string('bank_card', 32)->nullable()->comment('认证银行卡号');
                $table->string('mobile', 11)->nullable()->comment('认证联系手机号');
                $table->enum('auth_channel', ['def', 'gjk_work', 'lm_back', 'lm_api', 'gz_pl', 'gy_ly'])->comment('认证渠道：def-默认，gjk_work-家庭医生工作站，lm_back-朗玛移动（回调） lm_api-朗玛移动（接口调用） gz_pl-省平台银行卡验证 gy_ly-六医体检中心');
                $table->timestamp('authed_at')->comment('认证时间');
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
        Schema::connection('user')->dropIfExists('real_name_info');
    }
}
