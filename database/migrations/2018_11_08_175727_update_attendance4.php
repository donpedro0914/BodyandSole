<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAttendance4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn('day');
            $table->integer('day1')->nullable()->after('time_out');
            $table->integer('day2')->nullable()->after('day1');
            $table->integer('day3')->nullable()->after('day2');
            $table->integer('day4')->nullable()->after('day3');
            $table->integer('day5')->nullable()->after('day4');
            $table->integer('day6')->nullable()->after('day5');
            $table->integer('day7')->nullable()->after('day6');
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
