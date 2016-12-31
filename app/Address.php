<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'ADDRESS';
    protected $primaryKey = 'ENTITYID';
    public $incrementing = false;
    public $timestamps = false;
}
