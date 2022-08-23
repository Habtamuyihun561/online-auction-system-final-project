<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Winner;
use App\SubmitedDocuement;
use App\Models\Auction;
use App\User;
use App\Models\PostCategory;
use Carbon\Carbon;

class SelectWinners extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'winners:select';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Select Winner of The Auction';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $mytime = Carbon::now()->format('Y-m-d');

        $auctions=Auction::where('status','active')
         ->where('endDate', $mytime)->get();
      //
          //

          foreach($auctions as $auction){
              // return 'hello';

              if($auction->purpose='sale'){
               $WinnerUsers = SubmitedDocuement::where('auction_id', $auction->id)
                ->orderBy('total_price','DESC')->first();

                  // return $WinnerUsers->id;
                 }

              else if
              ($auction->purpose='buy'){
                  $WinnerUsers = SubmitedDocuement::where('auction_id', $auction->id)
                   ->orderBy('total_price','ASC')->first();


                  // first()
              }
             $user=User::find($WinnerUsers->user_id);
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
             Auction::where('id', $auction->id)
           ->update(['status' => 'deactivated']);



        }



        // foreach ($inactiveUsers as $user) {
        //     Mail::to($user)->send(new InactiveUsers($order));
        // }
    //     return 'winner is selected successfuly';
    }
}
