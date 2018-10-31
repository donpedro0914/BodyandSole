<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Giftcertificate extends Model
{
    protected $table = 'giftcertificates';

    protected $fillable = ['ref_no', 'gc_no', 'purchased_by', 'service', 'value', 'use', 'date_issued', 'expiry_date', 'status'];
}
