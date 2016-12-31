<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListHeader extends Model
{
    protected $table = 'LISTHEADER';
    protected $primaryKey = 'LISTID';
    public $incrementing = false;
    public $timestamps = false;
}
