<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->text('body', 500);
            $table->integer('user_id');
            $table->boolean('completed')->default(false);
            $table->timestamps();
        });

        Schema::create('agenda_item', function (Blueprint $table) {
            $table->integer('agenda_id');
            $table->integer('item_id');
            $table->primary(['agenda_id', 'item_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
        Schema::dropIfExists('agenda_item');
    }
}
