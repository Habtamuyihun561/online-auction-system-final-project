<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Document extends Model
{
    // product_name	product_type	product_measure	product_amount	product_price	total_price

    protected $fillable=[ 'product_name','product_type','product_measure', 'product_amount', 'product_price','is_most_important','user_id','auction_id'];
    public static function getAllDocument(){
        return Document::orderBy('id','DESC')->paginate(10);
    }
}
