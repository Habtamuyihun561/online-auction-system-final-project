<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubmitedDocuement extends Model
{
   protected $fillable=['total_price','collateral_payment','user_id','auction_id'];
    //
    public function author_info(){
        return $this->hasOne('App\User','id','user_id');
    }
    public static function countAuction(){
        $data=SubmitedDocuement::where('user_id',auth()->user()->id)->count();
        if($data){
            return $data;
        }
        return 0;
    }
}
