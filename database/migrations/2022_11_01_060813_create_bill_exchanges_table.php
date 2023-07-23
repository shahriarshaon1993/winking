<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillExchangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_exchanges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('drawn_under');
            $table->string('export');
            $table->date('export_date');
            $table->string('invoice_no');
            $table->date('invoice_date');
            $table->string('amount');
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
        Schema::dropIfExists('bill_exchanges');
    }
}
