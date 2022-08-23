<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Winner extends Model
{
    public static function countAuction(){
        $data=Winner::where('user_id',auth()->user()->id)->count();
        if($data){
            return $data;
        }
        return 0;
    }
    // protected $fillable=['full_name',];
    //
}
