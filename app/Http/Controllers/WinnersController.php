<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Winner;
use App\User;
use App\SubmitedDocuement;
use App\Models\Auction;
use App\Models\PostCategory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use App\Notifications\StatusNotification;
use App\Notifications\WinnerNotificationToUser;

class WinnersController extends Controller
{
    public function index(){
        // return 'winner is selected successfully';

        $mytime = Carbon::now()->format('Y-m-d');

       $auctions=Auction::where('status','active')->where('type','premium')
         ->where('endDate', $mytime)->get();
      //
          //
          if(count($auctions)>0){


          foreach($auctions as $auction){
            // return $auction->id;
              // return 'hello';


              if($auction->purpose='sale'){
               $WinnerUsers = SubmitedDocuement::where('auction_id', $auction->id)
                ->orderBy('total_price','DESC')->first();

                //   return $WinnerUsers->id;
                 }

              else if
              ($auction->purpose='buy'){
                $WinnerUsers = SubmitedDocuement::where('auction_id', $auction->id)
                   ->orderBy('total_price','ASC')->first();
                //    return $WinnerUsers->id;


                  // first()
              }

              if($WinnerUsers){
                // return $WinnerUsers->id;
                // foreach($WinnerUsers as $WinnerUser){
                //  $id= $WinnerUser->user_id;
                //  return $id;

           $user=User::find($WinnerUsers->user_id);
        //    return $user->name;

             $auction=Auction::find($WinnerUsers->auction_id);
             $auction->category_id;
             $category=PostCategory::find($auction->category_id);

              $winner=new Winner();
              $winner->full_name=$user->name;
              $winner->email=$user->email;
              $winner->phone=$user->phone;
              $winner->auction_code=$auction->code;
              $winner->auction_title=$auction->title;
              $winner->category=$category->title;
              $winner->auction_type=$auction->purpose;
              $winner->user_id=$WinnerUsers->user_id;
              $winner->auction_id=$WinnerUsers->auction_id;
             $winner->total_price=$WinnerUsers->total_price;
             $winner->save();

             $winner= User::where('id',$WinnerUsers->user_id)->first();
            //  $auctions=Auction::find($winner->auction_id);
            // $arraydata=[$winner->id,' Awared Notification Dear '. $winner->name.'You win the auction which is code '.$auction->code];
            $winner->notify(new WinnerNotificationToUser($winner,$auction));
             Auction::where('id', $auction->id)
           ->update(['status' => 'deactivated']);
                }







            //   else{
            //     return redirect()->back()->with('error','No Users submmit document');
            //     return 'No Users submmitted document';
            //   }
          //    $auction->status='deactivated';
          }

        //   return 'hello';
        return redirect()->route('auctionwinnerlist')->with('success','winner of Auctions is successfully  selected');
        }

        else{

            return redirect()->back()->with('error','No Auction is Avallable for selecction');
        }


          // $winner=Winner::get();
          // if(Auth::user()->role=='user')
          // return view('user.winner_list')->with('users',$winner);
          // else
          // return view('backend.users.winner_list')->with('users',$winner);
          //
          // return $WinnerUsers->id;

    }
    public function winnerList(){
        $winners=Winner::orderBy('id','DESC')->paginate(10);
        return view('backend.users.winner_list')->with('users',$winners);


    }
    public function toUserwinnerList(){
        $winners=Winner::orderBy('id','DESC')->paginate(6);
        return view('user.winner_list')->with('users',$winners);


    }

    //
}
