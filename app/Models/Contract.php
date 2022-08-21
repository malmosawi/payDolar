<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    
    protected $table = 'contract';
    public $timestamps = false;

    protected $fillable = [
        'id_customers', 'money', 'exchange_rate', 'add_rate','money_month', 'months_number','date','finish'
    ];

    
}
