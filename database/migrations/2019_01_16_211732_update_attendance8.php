<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAttendance8 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('time_in');
            $table->dropColumn('time_out');
            $table->dropColumn('day1');
            $table->dropColumn('day2');
            $table->dropColumn('day3');
            $table->dropColumn('day4');
            $table->dropColumn('day5');
            $table->dropColumn('day6');
            $table->dropColumn('day7');
            $table->dropColumn('no_of_hrs');
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
