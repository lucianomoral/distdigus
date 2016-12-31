<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemCost extends Model
{
    protected $table = 'ITEMCOST';
    protected $primaryKey = 'ITEMID';
    public $incrementing = false;
    public $timestamps = false;
}
