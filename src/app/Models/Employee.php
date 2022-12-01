<?php

namespace App\Models;

use App\Traits\employeeHandle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory , employeeHandle;
    protected $fillable = [
        'user_id' , 'tobaccoShop_id'
    ];

    
}
