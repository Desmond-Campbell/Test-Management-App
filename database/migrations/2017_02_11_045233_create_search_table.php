<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSearchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('search', function (Blueprint $table) {
            $table->engine = 'MYISAM';
            $table->increments('id');
            $table->string('hash', 40)->unique();
            $table->integer('project_id')->nullable()->default(0);
            $table->integer('object_id');
            $table->string('object_name');
            $table->string('object_type', 16);
            $table->text('keywords');
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });

        DB::statement('ALTER TABLE search ADD FULLTEXT full(keywords)');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('search');
    }
}
