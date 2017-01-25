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
        Schema::create('cases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id');
            $table->integer('section_id');
            $table->string('section_name', 50);
            $table->string('title', 128);
            $table->string('instructions')->nullable();
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('cases');
    }
}
