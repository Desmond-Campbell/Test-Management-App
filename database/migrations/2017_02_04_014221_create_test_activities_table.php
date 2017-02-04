<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_activities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('batch_id');
            $table->integer('project_id');
            $table->integer('test_id');
            $table->integer('case_id');
            $table->integer('time_elapsed')->nullable()->default(0);
            $table->integer('current_step')->nullable()->default(0);
            $table->text('completed_steps')->nullable();
            $table->text('skipped_steps')->nullable();
            $table->dateTime('start_time')->nullable();
            $table->smallInteger('status')->nullable()->default(0);
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
        Schema::dropIfExists('test_activities');
    }
}
