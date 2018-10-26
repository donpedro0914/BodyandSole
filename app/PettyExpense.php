<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PettyExpense extends Model
{
    protected $table = 'petty_expenses';

    protected $fillable = ['therapist', 'category', 'value'];
}
