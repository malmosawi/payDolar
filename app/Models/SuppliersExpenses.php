<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class SuppliersExpenses extends Model
{
    use SoftDeletes;
    
    protected $table = 'suppliers_expenses';
    public $timestamps = true;

    protected $fillable = [
        'id_suppliers', 'money', 'exchange_rate', 'date','note'
    ];

    
}
