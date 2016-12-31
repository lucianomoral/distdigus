<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'CUSTOMER';
    protected $primaryKey = 'CUSTID';
    public $incrementing = false;
    public $timestamps = false;
}
