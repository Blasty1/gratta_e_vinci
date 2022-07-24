<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteTobaccoShop extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delete_tobacco_shops',function (Blueprint $table)
        {
            $table->id();
            $table->string('token');
            $table->foreignId('tobaccoShop_id')->nullable();
            $table->foreign('tobaccoShop_id')->references('id')->on('tobacco_shops')->nullOnDelete();
            $table->timestamp('expires_at');
            $table->boolean("deleted")->default(false);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
