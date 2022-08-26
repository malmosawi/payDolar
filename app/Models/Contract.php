<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    
    use SoftDeletes;
    
    protected $table = 'contract';
    public $timestamps = true;

    protected $fillable = [
        'id_customers', 'money', 'exchange_rate', 'add_rate','money_month', 'months_number','date','finish'
    ];

    
}
