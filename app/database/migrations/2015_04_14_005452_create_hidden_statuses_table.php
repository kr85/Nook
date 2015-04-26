<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHiddenStatusesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hidden_statuses', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->unsignedInteger('status_id');
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');
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
        Schema::drop('hidden_statuses');
    }

}
