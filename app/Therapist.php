<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Therapist extends Model
{
    protected $table = 'therapists';

    protected $filalble = ['first_name', 'last_name', 'email', 'phone', 'address', 'avatar'];
}
