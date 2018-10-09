<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Updatejoborder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_orders', function (Blueprint $table) {
            $table->string('client_fullname')->nullable()->after('id');
            $table->string('therapist_fullname')->nullable();
            $table->string('category')->nullable();
            $table->string('service')->nullable();
            $table->string('payment')->nullable();
            $table->string('care_of')->nullable();
            $table->string('gcno')->nullable();
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
