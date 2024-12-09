<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientColumnMetadataTable extends Migration
{
    public function up()
    {
        Schema::create('client_column_metadata', function (Blueprint $table) {
            $table->id();
            $table->string('column_name')->unique();
            $table->string('data_type');
            $table->integer('length')->nullable();
            $table->boolean('is_boolean')->default(false);
            $table->boolean('nullable')->default(false); // Default to 0
            $table->string('default')->nullable();
            $table->integer('default_int')->nullable();
            $table->timestamps();
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('client_column_metadata');
    }
}
