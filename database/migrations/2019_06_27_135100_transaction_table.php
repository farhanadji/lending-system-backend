<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('transaction');
        Schema::create('transaction', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            $table->increments('id');
            $table->bigInteger('user_id')->unsigned();
            $table->float('total_price')->unsigned()->defaults(0);
            $table->date('borrow_date');
            $table->date('return_date');            
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaction', function(Blueprint $table){
            $table->dropForeign('user_id');
        });
        Schema::dropIfExists('transaction');
    }
}
