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
        Schema::table('prescription_pricings', function (Blueprint $table) {
            $table->unsignedBigInteger('prescription_id');
            $table->foreign('prescription_id')->references('id')->on('upload_prescriptions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prescription_pricings', function (Blueprint $table) {
            //
        });
    }
};
