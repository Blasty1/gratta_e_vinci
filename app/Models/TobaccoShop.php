<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TobaccoShop extends Model
{
    use HasFactory;
    protected $fillable = [
        'name' , 'street_address', 'user_id'
    ];
    protected $hidden = [
        'token'
    ];



    // $time refers to a timestamp that indicates the range where find items sold
    public function scratchAndWins($time=null)
    {
        $relationShip = $this->belongsToMany(ScratchAndWin::class,'scratch_and_win_tobacco_shop','tobaccoShop_id','scratchAndWin_id')->withPivot('employee_id','quantity','id','created_at','tokenPackage');
        if( $time ) return $relationShip->wherePivot('created_at','>=',$time);
        return $relationShip;
    }
    public function employees($id=null)
    {
        if($id) return $this->belongsToMany(User::class, 'employees','tobaccoShop_id','user_id')->wherePivot('user_id',$id)->get();
        return $this->belongsToMany(User::class, 'employees','tobaccoShop_id','user_id')->withPivot('created_at');
    }
    public function owner()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
