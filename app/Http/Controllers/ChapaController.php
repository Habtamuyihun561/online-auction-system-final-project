<?php

namespace App\Http\Controllers;

use Chapa\Chapa\Facades\Chapa as Chapa;
use App\SolledDocument;

class ChapaController extends Controller
{
    /**
     * Initialize Rave payment process
     * @return void
     */
    protected $reference;

    public function __construct(){
        $this->reference = Chapa::generateReference();

    }
    public function initialize($code)
    {
        // return $code;
       session()->put('code',$code);

        //This generates a payment reference
        $reference = $this->reference;
        $fullName=auth()->user()->name;
        $split = explode(" ",  $fullName);
        $firstname = array_shift($split);
        $lastname  = implode(" ", $split);


        // Enter the details of the payment
        $data = [

            'amount' => 100,
            'email' => auth()->user()->email,
            'tx_ref' => $reference,
            'currency' => "ETB",
            'callback_url' => route('callback',[$reference]),
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
            $code= session()->get('code');
            $this->docPayment();
            // return $code;

    //   return view('frontend.pages.about-us');
    return redirect()->route('showdocument',$code);

        // dd($data);
        }

        else{
            //oopsie something ain't right.
        }


    }
    public function docPayment(){


        return SolledDocument::create([
            'document_payment'=>100,
             'user_id'=>auth()->id(),
             'auction_id'=>session()->get('code'),
             'collateral_payment'=>session()->get('collateral_payment'),
        ]);
        }
}
