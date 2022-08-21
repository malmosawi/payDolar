<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    
    protected $table = 'setting';
    public $timestamps = false;

    protected $fillable = [
        'exchange_rate', 'add_rate', 'dolar_box', 'dinar_box',
    ];

    
}
