<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $fillable=['user_id','account_number','balance','status'];
    //
}
