<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScratchAndWinTobaccoShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scratch_and_win_tobacco_shop', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tobaccoShop_id');
            $table->foreignId('scratchAndWin_id');
            $table->integer('quantity');
            $table->foreignId('employee_id')->nullable();
            $table->string('tokenPackage');
            $table->string('numberOfPackage');

            $table->foreign('tobaccoShop_id')->references('id')->on('tobacco_shops')->onDelete('cascade');
            $table->foreign('scratchAndWin_id')->references('id')->on('scratch_and_wins')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('set null');

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
        Schema::dropIfExists('tobacco_shop_scratch_and_wins');
    }
}
