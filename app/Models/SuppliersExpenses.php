<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuppliersExpenses extends Model
{
    
    protected $table = 'suppliers_expenses';
    public $timestamps = false;

    protected $fillable = [
        'id_suppliers', 'money', 'exchange_rate', 'date',
    ];

    
}
