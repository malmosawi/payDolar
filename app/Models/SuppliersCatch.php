<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuppliersCatch extends Model
{
    use SoftDeletes;
    
    protected $table = 'suppliers_catch';
    public $timestamps = true;

    protected $fillable = [
        'id_suppliers', 'money', 'exchange_rate', 'date','note'
    ];

    
}
