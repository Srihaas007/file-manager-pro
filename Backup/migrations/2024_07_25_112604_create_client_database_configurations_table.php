<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientDatabaseConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_database_configurations', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id');
            $table->string('db_connection'); // e.g., 'mysql'
            $table->string('db_host');
            $table->string('db_port')->default('3306');
            $table->string('db_database');
            $table->string('db_username');
            $table->string('db_password');
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
        Schema::dropIfExists('client_database_configurations');
    }
}
