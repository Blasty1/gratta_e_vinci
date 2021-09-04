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




    public function scratchAndWins()
    {
        return $this->belongsToMany(ScratchAndWin::class,'scratch_and_win_tobacco_shop','tobaccoShop_id','scratchAndWin_id')->withPivot('employee_id','quantity','id','created_at')->wherePivot('created_at','>=',Carbon::today());
    }
    public function employees($id=null)
    {
        if($id) return $this->belongsToMany(User::class, 'employees','tobaccoShop_id','user_id')->where('user_id',$id)->get();
        return $this->belongsToMany(User::class, 'employees','tobaccoShop_id','user_id');
    }
    public function owner()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
