<?php

namespace App\Models;

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
        return $this->belongsToMany(ScratchAndWin::class)->withPivot('user_id','quantity');
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
