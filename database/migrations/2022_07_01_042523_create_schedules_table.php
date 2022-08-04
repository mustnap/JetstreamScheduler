<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            // $table->id();
            $table->date('date_scheduled');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('for_group_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('for_group_id')->references('id')->on('groups')->onDelete('cascade');
            // $table->dateTime('created_at');
            $table->timestamps();
            $table->primary(array('date_scheduled', 'user_id', 'for_group_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
};
