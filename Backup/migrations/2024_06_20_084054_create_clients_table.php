<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->unsignedInteger('client_id')->primary(); // Primary key
            $table->string('salt')->nullable();
            $table->string('api_secret_key', 64)->nullable(); // Store the hashed api_secret_key
            $table->string('api_token', 512)->nullable(); // Store the API token
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
