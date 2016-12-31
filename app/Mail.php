<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mail extends Model
{
    protected $table = 'MAIL';
    protected $primaryKey = 'ENTITYID';
    public $incrementing = false;
    public $timestamps = false;
}
