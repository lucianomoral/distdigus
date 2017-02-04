<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'USER';
    protected $primaryKey = 'USERID';
    public $incrementing = false;
    public $timestamps = false;
}
