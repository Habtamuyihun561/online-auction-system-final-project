<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
class PostCategory extends Model
{
    protected $fillable=['title','slug','status'];

    public function post(){
        return $this->hasMany('App\Models\Auction','category_id','id')->where('status','active');
    }

    public static function getBlogByCategory($slug){
        return PostCategory::with('post')->where('title',$slug)->first();
    }
    public static function countActiveCategory(){
        $data=PostCategory::where('status','active')->count();
        if($data){
            return $data;
        }
}
}
