<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommercialInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commercial_invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->unsignedInteger('export_id')->index();
            $table->string('exp_no');
            $table->string('shipment_terms');
            $table->string('payment_terms');
            $table->string('port_loading');
            $table->unsignedInteger('notify_party')->index();
            $table->unsignedInteger('bank_id')->index();
            $table->unsignedInteger('branch_id')->index();
            $table->json('description_good');
            $table->json('ctn_qty');
            $table->json('quantity_pcs');
            $table->json('unit_price');
            $table->json('total_price');
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
        Schema::dropIfExists('commercial_invoices');
    }
}
