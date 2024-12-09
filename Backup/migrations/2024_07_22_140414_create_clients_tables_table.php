<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTablesTable extends Migration
{
    public function up()
    {
        Schema::create('clients_tables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->string('table_name')->unique();
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('clients_tables');
    }
}
