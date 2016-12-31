<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemFamily extends Model
{
    protected $table = 'ITEMFAMILY';
    protected $primaryKey = 'ITEMFAMILYID';
    public $incrementing = false;
    public $timestamps = false;
}
