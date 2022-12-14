<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstallmentPay extends Model
{
    use SoftDeletes;
    
    protected $table = 'installment_pay';
    public $timestamps = true;

    protected $fillable = [
        'id_contract', 'date_contract', 'money_month', 'exchange_rate_benfit', 'months_number', 'date'
    ];

    
}
