<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGiftcertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('giftcertificates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('gc_no')->nullable();
            $table->string('purchased_by')->nullable();
            $table->string('service')->nullable();
            $table->string('value')->nullable();
            $table->string('use')->nullable();
            $table->string('date_issued')->nullable();
            $table->string('expiry_date')->nullable();
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
        Schema::dropIfExists('giftcertificates');
    }
}
