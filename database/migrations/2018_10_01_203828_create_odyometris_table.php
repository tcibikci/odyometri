<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOdyometrisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('odyometris', function (Blueprint $table) {
            $table->increments('id');
            $table->string('date', 15);
            $table->string('comment', 15)->nullable();
            $table->string('L250hz')->nullable();
            $table->string('L500hz')->nullable();
            $table->string('L1khz')->nullable();
            $table->string('L2khz')->nullable();
            $table->string('L3khz')->nullable();
            $table->string('L4khz')->nullable();
            $table->string('L6khz')->nullable();
            $table->string('L8khz')->nullable();
            $table->string('LSSO')->nullable();
            $table->string('R250hz')->nullable();
            $table->string('R500hz')->nullable();
            $table->string('R1khz')->nullable();
            $table->string('R2khz')->nullable();
            $table->string('R3khz')->nullable();
            $table->string('R4khz')->nullable();
            $table->string('R6khz')->nullable();
            $table->string('R8khz')->nullable();
            $table->string('RSSO')->nullable();
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
        Schema::dropIfExists('odyometris');
    }
}
