<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PettyExpense extends Model
{
    public $timestamps = false;

    protected $table = 'petty_expenses';

    protected $fillable = ['ref_no', 'therapist', 'category', 'particulars', 'value', 'created_at'];
}
