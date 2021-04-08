<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->integer('user_id');
            $table->integer('country_id');
            $table->integer('status_id');
            $table->integer('priority_id');
            $table->string('title');
            $table->text('description');
            $table->timestamps();

            $table->index('user_id');
            $table->index('country_id');
            $table->index(['status_id', 'priority_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
