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
        'id_customers', 'money_dolar', 'money_dinar', 'months_number', 'money_month', 'exchange_rate', 'exchange_rate_benfit', 'benfit_dolar', 'benfit_dinar', 'date', 'finish', 'note'
    ];

    
}
