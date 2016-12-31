<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustInvoiceLine extends Model
{
    protected $table = 'CUSTINVOICELINE';
    protected $primaryKey = 'INVOICEID';
    public $incrementing = false;
    public $timestamps = false;
}
