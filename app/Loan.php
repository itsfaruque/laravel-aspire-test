<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function users(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function repayments(){
        return $this->hasMany(Repayment::class);
    }

    public static function scopeOpenLoan($query){
        return $query->where('status','open');
    }
}
