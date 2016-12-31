<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemGroup extends Model
{
    protected $table = 'ITEMGROUP';
    protected $primaryKey = 'ITEMGROUPID';
    public $incrementing = false;
    public $timestamps = false;
}
