<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Therapist extends Model
{
    protected $table = 'therapists';

    protected $fillable = ['fullname', 'phone', 'address', 'dob', 'hired', 'resigned', 'basic', 'lodging', 'allowance', 'sss', 'phealth', 'hdf', 'uniform', 'fare', 'others', 'avatar', 'status'];
}
