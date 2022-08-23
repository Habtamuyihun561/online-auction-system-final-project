<?php

namespace App\Http\Controllers;

use Chapa\Chapa\Facades\Chapa as Chapa;
use Illuminate\Http\Request;
use App\Models\Auction;
use App\SubmitedDocuement;

use Auth;
class CollateralPaymentController extends Controller
{
    /**
     * Initialize Rave payment process
     * @return void
     */
    protected $reference;

    public function __construct(){
        $this->reference = Chapa::generateReference();

    }
    public function initialize(Request $request, $code)
     {

        $au=Auction::find($code);
        $cp = $au->collateral_percent;
        // return $code;
        // return   $au=Auction::find($code);
        // return $code;
         $au=Auction::find($code);
        $cp = $au->collateral_percent;
        $c=$request->total_price*$cp/100;
        $col=(int)$c;
        // return $col;

        // return $request->total_price;

        session()->put('total_price',$request->total_price);
        session()->put('user_id',Auth::user()->id);
        session()->put('auction_id',$code);
        // session()->put('total_price',$request->total_price);
        session()->put('collateral_payment',$c);
        $reference = $this->reference;
        $fullName=auth()->user()->name;
        $split = explode(" ",  $fullName);
        $firstname = array_shift($split);
        $lastname  = implode(" ", $split);
        //This generates a payment reference

        // Enter the details of the payment
        $data = [

            'amount' => $col,
            'email' => auth()->user()->email,
            'tx_ref' => $reference,
            'currency' => "ETB",
            'callback_url' => route('collateralcallback',[$reference]),
            'first_name' => $firstname,
            'last_name' => $lastname,
            "customization" => [
                "title" => 'test',
                "description" => "I amma testing this"
            ]
        ];

        $payment = Chapa::initializePayment($data);

        if ($payment['status'] !== 'success') {
            // notify something went wrong
            return 'error';
        }

        return redirect($payment['data']['checkout_url']);
    }

    /**
     * Obtain Rave callback information
     * @return void
     */
    public function callback($reference)
    {

        $data = Chapa::verifyTransaction($reference);
      //  dd($data);

        //if payment is successful
        if ($data['status'] ==  'success') {
            // return "Hello";
            $code= session()->get('auction_id');
        $this->cPaymentTransaction();
    //   return view('frontend.pages.about-us');
    return redirect()->route('home')->with('success','You are successfully paid the collateral');

        // dd($data);
        }

        else{
            //oopsie something ain't right.
        }


    }



    public function cPaymentTransaction(){


        return SubmitedDocuement::create([
            'total_price'=>session()->get('total_price'),
             'user_id'=>auth()->id(),
             'auction_id'=>session()->get('auction_id'),
             'collateral_payment'=>session()->get('collateral_payment'),
        ]);
        }
}
