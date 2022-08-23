<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Auction;
// use App\Models\Contract;
use App\Contract;
use App\Winner;
use App\Balance;
use App\SubmitedDocuement;
use App\Models\Document;
use App\Models\PostCategory;
// use App\Models\PostTag;
use App\User;
use Hash;
use Session;
use Auth;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        {

            $contracts=Contract::where('user_id',auth()->user()->id)->orderBy('created_at','DESC')->paginate(7);
            // return $posts;
            return view('user.contract.index')->with('contracts',$contracts);
        }
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_id=auth()->id();
        $categories=PostCategory::get();
        $posts=Auction::where('user_id',$user_id)->where('status','deactivated')->get();
        $users=User::get();
        return view('user.contract.create')->with('users',$users)->with('categories',$categories)->with('posts',$posts);

        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description'=>'required',
            'auction_id'=>'',

        ]);
        $data=$request->all();
        $check=$this->createContract($data);
       $this->collateral($request->auction_id);
        Session::put('auction',$data['title']);
        // $status=Auction::create($data);

        if($check){
                request()->session()->flash('success','Contract Successfully added and Collateral Payment is also Returned');
                return redirect()->route('contract.index');

        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        // return redirect()->route('post.index');
    }
    public function createContract(array $data){
        return Contract::create([
            'title'=>$data['title'],
            'description'=>$data['description'],
             'user_id'=>auth()->id(),
             'auction_id'=>$data['auction_id'],
            ]);

        }
        public function collateral($auction_id){
            $collaterals=SubmitedDocuement::where('auction_id',$auction_id)->get();
            if(count($collaterals )>0){
                foreach($collaterals as $collateral){
                    if (Winner::where('user_id', $collateral->user_id)->exists()) {
                        // collateral payment is not retruned
                     }
                     else{
                        $balance=Balance::where('user_id', $collateral->user_id)->first();
                        $amount=$balance->balance;
                        $collateral_payment=$collateral->collateral_payment;
                        $balance=$amount + $collateral_payment;
                        Balance::where('user_id', $collateral->user_id)->update(['balance' =>$balance]);
                     }
                }

            }
            // request()->session()->flash('success','Contract Successfully added');
            //     return redirect()->route('contract.index');
        }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contract=Contract::findOrFail($id);
        $categories=PostCategory::get();
        $auctions=Auction::where('id',$contract->auction_id)->first();
        // $tags=PostTag::get();
        $users=User::get();
        return view('user.contract.edit')->with('categories',$categories)->with('auctions',$auctions)->with('contract',$contract);
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $contract=Contract::findOrFail($id);
        // return $request->all();
        $validatedData=$request->validate([
           'title'=>'string|required',
           'description'=>'string|nullable',
           'auction_id'=>'',
        //    'user_id'=>auth()->user()->id,
       ]);
      $status= Contract::whereId($id)->update($validatedData);
       if($status){
           request()->session()->flash('success','Contract Successfully updated');
           return redirect()->route('contract.index');
       }
       else{
           request()->session()->flash('error','Please try again!!');
       }

        //
        //    'added_by'=>'nullable',
        //    '
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contract=Contract::findOrFail($id);

        $status=$contract->delete();

        if($status){
            request()->session()->flash('success','Contract successfully deleted');
        }
        else{
            request()->session()->flash('error','Error while deleting Auction ');
        }
        return redirect()->route('contract.index');
    }
     public function winnercontrat(){
        $contracts=Contract::orderBy('created_at','DESC')->paginate(7);
        // return $posts;
        return view('user.contract.winnercontrat')->with('contracts',$contracts);

     }
}
        //


