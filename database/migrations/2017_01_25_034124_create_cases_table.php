<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_cases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id');
            $table->integer('suite_id');
            $table->integer('scenario_id');
            $table->string('name');
            $table->text('instructions')->nullable();
            $table->text('description')->nullable();
            $table->text('pass_criteria')->nullable();
            $table->text('fail_criteria')->nullable();
            $table->decimal('item_position', 4, 2)->nullable()->default(0);
            $table->integer('user_id');
            $table->smallInteger('status')->default(1);
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
        Schema::dropIfExists('test_cases');
    }
}
