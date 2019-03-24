<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends \App\Database\Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            // Attributes
            $table->string('name');
            $table->string('surname')->nullable();
            $table->string('slug');
            $table->string('email')->unique()->nullable();
            $table->text('password');
            $table->rememberToken();
            // Foreign keys
            $this->references('groups', $table)->nullable()->default(null);
            $this->references('positions', $table)->nullable()->default(null);
            $this->references('permissions', $table)->nullable()->default(null);
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
        Schema::dropIfExists('users');
    }
}
