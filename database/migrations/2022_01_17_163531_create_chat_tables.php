<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_msgs', function (Blueprint $table) {
            $table->increments('chat_msg_id');
            $table->integer('chat_group_id');
            $table->longText('message');
            $table->integer('created_by');
            $table->timestamps();
        });

        Schema::create('chat_groups', function (Blueprint $table) {
            $table->increments('chat_group_id');
            $table->integer('created_by');
            $table->string('group_name');
            $table->timestamps();
        });

        
        Schema::create('chat_users', function (Blueprint $table) {
            $table->increments('chat_group_id');
            $table->integer('user_id');
            $table->timestamp('last_visit')->default(now());
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
        //
    }
}
