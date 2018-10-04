<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    protected $table = 'clients';

    protected $fillable = ['fullname', 'phone', 'email', 'dob', 'occupation', 'sc_id'];
}
