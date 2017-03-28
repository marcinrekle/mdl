<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fields', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name',64);
            $table->string('slug',32);
            $table->text('description');
            $table->string('type',32);
            $table->smallInteger('order')->default(0);
            $table->boolean('active')->default(0);
            $table->boolean('visible')->default(0);
            $table->boolean('require')->default(0);
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
        Schema::dropIfExists('fields');
    }
}
