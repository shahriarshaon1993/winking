<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_id');
            $table->integer('user_id');
            $table->integer('rivision_no');
            $table->date('order_date');
            $table->integer('vendor');
            $table->integer('invoice_to');
            $table->integer('ship_to');
            $table->string('season');
            $table->date('ship_exp_date');
            $table->date('cancel_date');
            $table->string('ship_terms');
            $table->string('payment_terms');
            $table->string('febric_ref')->nullable();
            $table->string('brand');
            $table->string('style_no');
            $table->string('ca');
            $table->integer('total_quantity');
            $table->double('unit_price');
            $table->double('amount');
            $table->string('fabrication')->nullable();
            $table->string('description')->nullable();
            $table->boolean('is_active');
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
        Schema::dropIfExists('purchase_orders');
    }
}
