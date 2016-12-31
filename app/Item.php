<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'ITEM';
    protected $primaryKey = 'ITEMID';
    public $incrementing = false;
    public $timestamps = false;
}
