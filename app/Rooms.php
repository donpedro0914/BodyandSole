<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rooms extends Model
{
    protected $table = 'rooms_lounges';

    protected $fillable = ['name', 'type', 'status'];
}
