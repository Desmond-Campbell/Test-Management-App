<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScenariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_scenarios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id');
            $table->integer('suite_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->text('files');
            $table->integer('children')->nullable()->default(0);
            $table->integer('user_id');
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
        Schema::dropIfExists('test_scenarios');
    }
}
