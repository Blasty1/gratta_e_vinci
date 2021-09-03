<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Monthly extends Model
{
    use HasFactory;
    protected $fillable = [
        'money_got'
    ];
    protected $casts = [
        'scratch_and_win_sold' => 'array',
        'month' => 'date:Y-m'
    ];
}
