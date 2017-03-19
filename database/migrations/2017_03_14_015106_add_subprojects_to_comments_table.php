<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubprojectsToCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->integer('subproject')->nullable();
        });
        Schema::table('comments', function (Blueprint $table) {
            $table->integer('subproject_beebole_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comments', function(Blueprint $table){
            $table->dropColumn('subproject');
        });
        Schema::table('comments', function(Blueprint $table){
            $table->dropColumn('subproject_beebole_id');
        });
    }
}
