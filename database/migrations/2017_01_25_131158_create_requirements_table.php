<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requirements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id');
            $table->integer('section_id');
            $table->string('section_name', 50);
            $table->integer('parent_requirement_id')->nullable();
            $table->string('parent_requirement_name')->nullable();
            $table->integer('has_children')->nullable()->default(0);
            $table->string('summary');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('requirements');
    }
}
