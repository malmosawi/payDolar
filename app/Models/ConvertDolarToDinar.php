<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ConvertDolarToDinar extends Model
{
    use SoftDeletes;
    
    protected $table = 'convertdolartodinar';
    public $timestamps = true;

    protected $fillable = [
        'money_dolar', 'money_dinar', 'exchange_rate', 'date'
    ];

    
}
