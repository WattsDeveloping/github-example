<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepoDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repo_data', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('user_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('html_url')->nullable();
            $table->integer('stargazers_count')->nullable();
            $table->timestamp('updated_at');
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('repo_data');
    }
}
