<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    
    protected $table = 'setting';
    public $timestamps = false;

    protected $fillable = [
        'exchange_rate', 'exchange_rate_benfit', 'benfit_dolar', 'benfit_dinar', 'dolar_box', 'dinar_box',
    ];

    
}
