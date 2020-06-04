<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sums', function (Blueprint $table) {
            $table->id();
            $table->unsignedbiginteger('event_id');
            // $table->biginteger('user_id');
            $table->integer('table');
            $table->integer('number');
            $table->integer('faults')->default('0');
            $table->integer('answer')->nullable();
            $table->integer('result')->default('2');
            $table->integer('time')->default('0');
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
        Schema::dropIfExists('sums');
    }
}
