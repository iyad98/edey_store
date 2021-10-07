<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->bigIncrements('admin_id');
            $table->string('admin_name');
            $table->string('admin_image')->nullable();
            $table->string('admin_username')->nullable();
            $table->string('admin_phone')->nullable();
            $table->string('admin_email')->unique();
            $table->tinyInteger('admin_role')->nullable();
            $table->timestamp('admin_email_verified_at')->nullable();
            $table->string('password');
            $table->tinyInteger('admin_status')->default(1);
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
        Schema::dropIfExists('admins');
    }
}
