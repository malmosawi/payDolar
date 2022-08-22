<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customers extends Model
{
    use SoftDeletes;
    
    protected $table = 'customers';
    public $timestamps = true;

    protected $fillable = [
        'name', 'address', 'phone', 'mother_name', 'identification_number', 'identification_version', 'identification_date', 'year', 'job', 'job_place', 'bank_name', 'card_password', 'phone_council', 'person_image',
    ];

    
}
