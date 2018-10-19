<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Packages extends Model
{
    protected $table = 'packages';

    protected $fillable = ['package_name', 'services', 'price', 'labor', 'status'];
}
