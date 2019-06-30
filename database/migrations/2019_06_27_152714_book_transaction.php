<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BookTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_transaction', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->Integer('transaction_id')->unsigned();
            $table->Integer('book_id')->unsigned();          
            $table->timestamps();

            $table->foreign('transaction_id')->references('id')->on('transaction');
            $table->foreign('book_id')->references('id')->on('books');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('book_transaction', function(Blueprint $table){
            $table->dropForeign(['transaction_id']);
            $table->dropForeign(['book_id']);
        });

        Schema::dropIfExists('book_transaction');
    }
}
