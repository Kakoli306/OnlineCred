<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortalAccessEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portal_access_emails', function (Blueprint $table) {
            $table->id();
            $table->integer('admin_id')->nullable();
            $table->integer('provider_id')->nullable();
            $table->string('email')->nullable();
            $table->string('verify_id')->nullable();
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
        Schema::dropIfExists('portal_access_emails');
    }
}
