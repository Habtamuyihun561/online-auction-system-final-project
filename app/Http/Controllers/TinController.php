<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SupplierList;
use App\User;

class TinController extends Controller
{
    public function update(Request $request){

        //  $tin=$request->all();
         $tin=$this->checktinNumber($request->tin_number);
        // return $tin['tin_number'];
        if($tin){
            if (User::where('tin_number', $request->tin_number)->exists()) {
                return redirect()->back()->with('success','Please enter Your Correct tin number');
                // post with the same slug already exists
             }
             else{
                User::where('id', auth()->user()->id)
                ->update(['tin_number' =>$request->tin_number]);
              return redirect()->back()->with('success','Tin NUmber Successfully registered');
            }
        }
        else{
            return redirect()->back()->with('success','Please Enter The Corect Tin Number');
        }

    //
}
public function checktinNumber($tin_num){
    if (SupplierList::where('tin_number', $tin_num)->exists()) {
        return true;
        // post with the same slug already exists
     }
     else{
        return false;
     }
    // return $tin_num;
    //  return $response = Http::get('http://localhost:8000/api/tinumber/$tin_num' ,[
    //     'tin_num' => $tin_num,
    //     // 'page' => 1,
    // ]);
}
}
