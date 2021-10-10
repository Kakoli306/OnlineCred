<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProviderInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('admin_id')->nullable();
            $table->integer('provider_id')->nullable();
            $table->string('suffix')->nullable();
            $table->string('speciality')->nullable();
            $table->string('tax_id')->nullable();
            $table->string('ssn')->nullable();
            $table->string('npi')->nullable();
            $table->string('upin')->nullable();
            $table->string('dea')->nullable();
            $table->string('state_licence')->nullable();
            $table->string('patient_number')->nullable();
            $table->date('signature_date')->nullable();
            $table->integer('signature_on_file')->nullable();
            $table->text('sig_file')->nullable();
            $table->integer('rp')->nullable();
            $table->integer('ocp')->nullable();
            $table->integer('mp')->nullable();
            $table->integer('anp')->nullable();
            $table->integer('pdop')->nullable();
            $table->integer('app')->nullable();
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
        Schema::dropIfExists('provider_infos');
    }
}
