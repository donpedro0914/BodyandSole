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
            $table->string('gc_no')->nulalble();
            $table->string('purchased_by')->nulalble();
            $table->string('service')->nulalble();
            $table->string('value')->nulalble();
            $table->string('use')->nulalble();
            $table->string('date_issued')->nulalble();
            $table->string('expiry_date')->nulalble();
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
