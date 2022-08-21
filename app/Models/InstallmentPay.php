<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstallmentPay extends Model
{
    
    protected $table = 'installment_pay';
    public $timestamps = false;

    protected $fillable = [
        'id_contract', 'money', 'exchange_rate', 'money_month', 'months_number', 'date'
    ];

    
}
