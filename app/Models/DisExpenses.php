<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DisExpenses extends Model
{
    use SoftDeletes;
    
    protected $table = 'dis_expenses';
    public $timestamps = true;

    protected $fillable = [
        'id_expenses','money' , 'exchange_rate', 'date',
    ];

    
}
