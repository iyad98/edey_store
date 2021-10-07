<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationAppUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_app_users', function (Blueprint $table) {
            
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('user_id');
            $table->tinyInteger('type');
            $table->string('data');
            $table->timestamp('read_at')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification_app_users');
    }
}
