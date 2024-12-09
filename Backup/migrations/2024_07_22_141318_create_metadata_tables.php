<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetadataTables extends Migration
{
    public function up()
    {
        Schema::create('metadata_tables', function (Blueprint $table) {
            $table->id();
            $table->string('column_name');
            $table->string('client_column_name');
            $table->string('data_type')->default('string');
            $table->integer('length')->nullable();
            $table->boolean('is_boolean')->default(false);
            $table->boolean('nullable')->default(false);
            $table->string('default')->nullable();
            $table->integer('default_int')->nullable();
            $table->string('true_value')->nullable();
            $table->string('false_value')->nullable();
            $table->integer('client_id');
            $table->unsignedBigInteger('table_id');
            $table->string('table_name'); // Ensure this field is included
            $table->timestamps();

            $table->foreign('table_id')->references('id')->on('clients_tables')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('metadata_tables');
    }
}
