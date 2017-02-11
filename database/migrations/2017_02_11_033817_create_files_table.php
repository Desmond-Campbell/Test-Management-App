<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->nullable()->default(0);
            $table->integer('network_id')->nullable()->default(0);
            $table->integer('object_id');
            $table->string('name');
            $table->string('path');
            $table->string('type');
            $table->string('extension', 10)->nullable();
            $table->integer('size');
            $table->text('variables')->nullable();
            $table->integer('created_by');
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
        Schema::dropIfExists('files');
    }
}
