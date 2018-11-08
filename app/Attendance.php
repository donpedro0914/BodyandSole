<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendances';

    protected $fillable = ['name', 'time_in', 'time_out', 'day1', 'day2', 'day3', 'day4', 'day5', 'day6', 'day7'];
}
