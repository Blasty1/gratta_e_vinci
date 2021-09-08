<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScratchAndWinTobaccoShop extends Model
{
    use HasFactory;
    protected $fillable = [
        'quantity' , 
        'employee_id', // who has sold the item
        'tobaccoShop_id',
        'scratchAndWin_id',
        'tokenPackage',
        'numberOfPackage'
    ];
    protected $table = 'scratch_and_win_tobacco_shop';

}
