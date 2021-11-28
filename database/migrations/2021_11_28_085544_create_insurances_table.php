<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsurancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insurances', function (Blueprint $table) {
            $table->id();
            $table->integer('admin_id')->nullable();
            $table->string('insurnace_name')->nullable();
            $table->string('insurnace_type')->nullable();
            $table->string('insurnace_practice_name')->nullable();
            $table->string('insurnace_country')->nullable();
            $table->string('insurnace_city')->nullable();
            $table->string('insurnace_state')->nullable();
            $table->string('insurnace_contract')->nullable();
            $table->string('insurnace_phone')->nullable();
            $table->string('insurnace_email')->nullable();
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
        Schema::dropIfExists('insurances');
    }
}
