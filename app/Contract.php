<?php
// namespace App\Models;
namespace App;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable=['title','description','user_id','winner_id','auction_id'];
    public function cat_info(){
        return $this->hasOne('App\Models\PostCategory','id','category');
    }
    public function author_info(){
        return $this->hasOne('App\User','id','user_id');
    }
    public static function getAllContract(){
        return Contract::with(['cat_info','author_info'])->orderBy('id','DESC')->paginate(10);
    }
}
