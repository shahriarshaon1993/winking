<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForwaringLettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forwaring_letters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->unsignedInteger('bank_id')->index();
            $table->unsignedInteger('branch_id')->index();
            $table->unsignedInteger('export_id')->index();
            $table->string('reference_bank');
            $table->string('reference_no');
            $table->string('shipper_bank');
            $table->string('shipper_ref');
            $table->string('reference_no');
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
        Schema::dropIfExists('forwaring_letters');
    }
}
