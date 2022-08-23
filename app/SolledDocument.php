<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SolledDocument extends Model
{
    protected $fillable=['auction_id','user_id','document_payment'];
    //
    public static function totalEarning(){
        $data=SolledDocument::get();
        $a=count($data);
        if($a){
            return $a *100;
        }
        else {
            return 0;
        }




    }
}
