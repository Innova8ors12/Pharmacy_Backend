<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pricing_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prescription_pricing_id');
            $table->string('medicine_name',50);
            $table->string('medicine_qty');
            $table->string('medicine_price');
            $table->foreign('prescription_pricing_id')->references('id')->on('prescription_pricings');
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
        Schema::dropIfExists('pricing_items');
    }
};
