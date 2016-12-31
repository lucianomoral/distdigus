<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustInvoiceHeader extends Model
{
    protected $table = 'CUSTINVOICEHEADER';
    protected $primaryKey = 'INVOICEID';
    public $incrementing = false;
    public $timestamps = false;
}
