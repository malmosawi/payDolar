<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ConvertDinarToDolar extends Model
{
    use SoftDeletes;
    
    protected $table = 'convertdinartodolar';
    public $timestamps = true;

    protected $fillable = [
        'money_dolar', 'money_dinar', 'exchange_rate', 'date'
    ];

    
}
