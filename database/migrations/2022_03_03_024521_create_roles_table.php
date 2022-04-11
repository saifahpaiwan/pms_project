<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->integer('permission_id');
            $table->integer('roles_systems_id');
            $table->char('view', 1)->nullable()->default('N');
            $table->char('add', 1)->nullable()->default('N');
            $table->char('edit', 1)->nullable()->default('N');
            $table->char('delete', 1)->nullable()->default('N');
            $table->char('export', 1)->nullable()->default('N');
            $table->timestamps();
            $table->char('deleted_at', 1)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
