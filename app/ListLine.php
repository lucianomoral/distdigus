<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListLine extends Model
{
    protected $table = 'LISTLINE';
    protected $primaryKey = 'LISTID';
    public $incrementing = false;
    public $timestamps = false;
}
