<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobOrder extends Model
{
    protected $table = 'job_orders';

    protected $fillable = ['job_order', 'room_no_form', 'client_fullname', 'therapist_fullname', 'category', 'service', 'payment', 'care_of', 'gcno', 'status', 'price', 'day0', 'day1', 'day2', 'day3', 'day4', 'day5', 'day6'];
}
