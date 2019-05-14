<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            
            $table->bigIncrements('id');
            $table->bigInteger('owner_id')->unsigned();
            $table->foreign('owner_id')->references('id')->on('owners');
            $table->string('type');
            $table->string('name');
            $table->string('address');
            $table->string('city');
            $table->string('country');
            $table->string('zipcode');
            $table->integer('totalSlots');
            $table->integer('availableSlots');
			$table->string('status')->nullable();
			$table->integer('rating')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('places');
    }
}
