<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->tinyInteger('email')->default(0)->nullable();
            $table->tinyInteger('sms')->default(0)->nullable();
            $table->tinyInteger('notification')->default(0)->nullable();
            $table->tinyInteger('popup')->default(0)->nullable();
            $table->string('sms_patternCode')->nullable();
            $table->longText('sms_variables')->nullable();
            $table->string('lang', 30)->default('fa');
            $table->enum('status',['active','inactive'])->default('active')->nullable();
            $table->enum('status_send',['pending','sent','cancel'])->default('pending')->nullable();
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
        Schema::dropIfExists('messages');
    }
}
