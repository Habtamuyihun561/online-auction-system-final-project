<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auction;
use App\User;
use App\SolledDocument;


class ReportControlller extends Controller
{
    public function index(){

        $auction=Auction::where('status','active')->count();
        $data=Auction::where('status','deactivated')->count();
        $user=User::where('status','active')->count();
        $doc=SolledDocument::get();
        $document=count($doc);
        $price=$document*100;

        $inactiveauction=Auction::where('status','deactivated')->count();

        return view('backend.report')->with('active',$auction)
        ->with('deactive',$data)
        ->with('user',$user)
        ->with('doc',$document)
        ->with('price',$price);
    }
    //
}
