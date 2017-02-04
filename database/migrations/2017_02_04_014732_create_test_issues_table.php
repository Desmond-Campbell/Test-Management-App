<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_issues', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id');
            $table->integer('activity_id');
            $table->integer('step_id');
            $table->string('type', 16);
            $table->string('title');
            $table->text('details');
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
        Schema::dropIfExists('test_issues');
    }
}
