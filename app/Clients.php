<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    protected $table = 'clients';

    protected $fillable = ['first_name', 'last_name', 'phone', 'email', 'dob', 'occupation', 'sc_id'];
}
