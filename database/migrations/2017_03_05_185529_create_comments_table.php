<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('trouble_ticket_id');
            $table->integer('user_id');
            $table->integer('company_id');
            $table->string('company');
            $table->integer('company_beebole_id');
            $table->string('project');
            $table->integer('project_beebole_id');
            $table->integer('task_id');
            $table->string('task');
            $table->integer('task_beebole_id');
            $table->float('time_spent');
            $table->text('body');
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
        Schema::dropIfExists('comments');
    }
}
