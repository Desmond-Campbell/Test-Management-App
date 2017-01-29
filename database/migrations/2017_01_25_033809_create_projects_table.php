<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 50);
            $table->string('description')->nullable();
            $table->string('type', 32)->nullable()->default('Other');
            $table->string('colour', 16)->nullable();
            $table->integer('owner_id');
            $table->integer('user_id');
            $table->integer('default_section_id')->nullable()->default(0);
            $table->integer('default_requirement_section_id')->nullable()->default(0);
            $table->smallInteger('status')->default(0);
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
        Schema::dropIfExists('projects');
    }
}
