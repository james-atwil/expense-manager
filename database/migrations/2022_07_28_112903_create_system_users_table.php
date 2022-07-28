<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('email')->nullable();
            $table->text('password')->nullable();
            $table->text('name_display')->nullable();
            $table->unsignedInteger('role_id')->nullable()->index('fk_roles_users');
            $table->unsignedInteger('is_active')->default(1);
            $table->text('remember_token')->nullable();
            $table->text('notes')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_users');
    }
}
