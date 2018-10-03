<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    protected $table = 'services';

    protected $fillable = ['service_name', 'labor_s', 'labor_p', 'charge', 'status'];
}
