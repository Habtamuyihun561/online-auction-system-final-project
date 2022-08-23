<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Auction extends Model
{
    protected $fillable=['code','title','category_id','description', 'startDate', 'endDate','min_price','photo','type','status','user_id','purpose','collateral_percent'];


    public function cat_info(){
        return $this->hasOne('App\Models\PostCategory','id','category_id');
    }
    public function documents(){
        return $this->hasMany('App\Models\Document');
   }
   public function submitteddocuments(){
    return $this->hasMany('App\SubmitedDocuement');
}

public function winner(){
 return $this->hasMany('App\Winner');
}
    public function tag_info(){
        return $this->hasOne('App\Models\PostTag','id','post_tag_id');
    }
    public function get_comments(){
        return $this->hasMany('App\Models\PostComment','post_id','id');
    }
    public static function getPostBySlug($slug){
        return Auction::where('id',$slug)->where('status','active')->where('type','premium')->orderBy('created_at','ASC')->first();
    }
    public static function getfreePostBySlug($slug){
        return Auction::where('id',$slug)->where('status','active')->where('type','free')->first();
    }
    public function author_info(){
        return $this->hasOne('App\User','id','user_id');
    }
    public static function getAllAuction(){
        return Auction::with(['cat_info','author_info'])->orderBy('id','DESC')->paginate(7);
    }
    public static function countActiveAuction(){
        $data=Auction::where('status','active')->count();
        if($data){
            return $data;
        }
        return 0;
    }

    public static function countDeactivatedAuction(){
        $data=Auction::where('status','deactivated')->count();
        if($data){
            return $data;
        }
        return 0;
    }

    public static function countAllAuction(){
        // $data=Auction::where('','deactivated')->count();
        $data=Auction::get();
        return $d=count($data);

        return $data;
        // $d=countDeactivatedAuction();
        // $a=countActiveAuction();
        // $data=$a + $d;
        if($data){
            return $data;
        }
        return 0;
    }




    protected $dateFormat = 'Y-m-d H:i';
//addition
    public function getNextAttribute(){
        return static::where('id', '>', $this->id)->orderBy('id','asc')->first();
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public  function getPreviousAttribute(){
        return static::where('id', '<', $this->id)->orderBy('id','desc')->first();
    }

}
