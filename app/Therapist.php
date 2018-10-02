<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Therapist extends Model
{
    protected $table = 'therapists';

    protected $fillable = ['first_name', 'last_name', 'phone', 'address', 'dob', 'hired', 'resigned', 'lodging', 'allowance', 'sss', 'phealth', 'hdf', 'uniform', 'fare', 'others', 'avatar', 'status'];
}
