<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLcNoAndShipViaAndInstructionNotesAndPackingInstructionToPurchaseOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->string('lc_no')->after('rivision_no');
            $table->string('ship_via')->after('style_no');
            $table->text('packing_instruction')->after('fabrication');
            $table->text('instruction_notes')->after('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->dropColumn('lc_no');
            $table->dropColumn('ship_via');
            $table->dropColumn('packing_instruction');
            $table->dropColumn('instruction_notes');
        });
    }
}
