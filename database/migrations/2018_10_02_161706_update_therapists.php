<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTherapists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('therapists', function (Blueprint $table)
        {
            $table->string('dob')->nullable()->after('address');
            $table->string('hired')->nullable();
            $table->string('resigned')->nullable();
            $table->string('lodging')->nullable();
            $table->string('allowance')->nullable();
            $table->string('sss')->nullable();
            $table->string('phealth')->nullable();
            $table->string('hdf')->nullable();
            $table->string('uniform')->nullable();
            $table->string('fare')->nullable();
            $table->string('others')->nullable();
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
