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
            $table->foreign('places_owners_id')->references('id')->on("places_owners");
            $table->string('type');
            $table->string('name');
            $table->string('address');
            $table->string('city');
            $table->string('country');
            $table->string('zipcode');
            $table->int('totalSlots');
            $table->int('availableSlots');
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
