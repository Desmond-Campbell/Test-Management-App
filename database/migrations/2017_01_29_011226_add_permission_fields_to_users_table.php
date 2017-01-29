<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPermissionFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('sso_id')->after('remember_token')->nullable();
            $table->text('roles')->after('sso_id')->nullable();
            $table->text('key_overrides')->after('roles')->nullable();
            $table->text('key_restrictions')->after('key_overrides')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn( [ 'sso_id', 'roles', 'key_overrides', 'key_restrictions' ] );
        });
    }
}
