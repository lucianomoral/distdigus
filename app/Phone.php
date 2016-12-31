<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    protected $table = 'PHONE';
    protected $primaryKey = 'ENTITYID';
    public $incrementing = false;
    public $timestamps = false;
}
