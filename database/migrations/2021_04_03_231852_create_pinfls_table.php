<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePinflsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pinfls', function (Blueprint $table) {
            $table->id();
            $table->string('pinfl',15)->nullable();
            $table->string('surname_cyr',60)->nullable();
            $table->string('name_cyr',60)->nullable();
            $table->string('middlename_cyr',60)->nullable();
            $table->string('birth_date',60)->nullable();
            $table->string('passport_number',60)->nullable();
            $table->string('issue_place',256)->nullable();
            $table->string('birth_place',256)->nullable();
            $table->string('living_place',256)->nullable();
            $table->string('address',256)->nullable();
            $table->boolean('attached')->default(false);

            $table->index('middlename_cyr');
            $table->index('name_cyr');
            $table->index('birth_date');
            $table->index('birth_place');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pinfls');
    }
}
