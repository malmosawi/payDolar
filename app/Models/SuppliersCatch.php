<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuppliersCatch extends Model
{
    
    protected $table = 'suppliers_catch';
    public $timestamps = false;

    protected $fillable = [
        'id_suppliers', 'money', 'exchange_rate', 'date',
    ];

    
}
