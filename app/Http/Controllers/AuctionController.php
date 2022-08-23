<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Auction;
use App\Models\Document;
use App\Models\PostCategory;
use App\Models\PostTag;
use Illuminate\Support\Facades\Notification;
use App\Notifications\StatusNotificationToUser;
use App\User;
use Hash;
use Session;
use Auth;



class AuctionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return auth()->user()->id;
        $auctions=Auction::where('user_id',auth()->user()->id)->paginate(6);
        // return $posts;
        //  dd($auctions);
        return view('user.auction.index')->with('posts',$auctions);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=PostCategory::get();

        $users=User::get();
        return view('user.auction.create')->with('users',$users)->with('categories',$categories);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //  auction_name	category	description	startDate	endDate	status	min_price	photo	openedTime	auctioneer_id
    public function store(Request $request)
    {
        // return $request->all();
        $this->validate($request,[
            'code'=>'required',
            'title'=>'required',
            'category_id' =>'required',
            'description'=>'required',
            'startDate'=>'required',
            // 'openedTime'=>'required',
            'endDate' => 'required',
            'min_price'=>'nullable',
            'photo'=>'nullable',
            'type'=>'required',
            'purpose'=>'required',
            'collateral_percent'=>''
            // 'status'=>'required|in:active,inactive'
        ]);

        // product_name	product_type	product_measure	product_amount	product_price	total_price

        $data=$request->all();
        // return $currentURL = url()->current();
        // return $data['photo'];
        $name=null;
        if($request->hasFile('photo')){
        //     $destnation_path='public/images/products';
            $file=$request->file('photo');
        $name = Str::random(5).time().'.'.$file->extension();
           $file->move(public_path().'/images/products/', $name);
           $data['photo']=$name;
        }



        //     $imageName = time().auth()->user()->id.'.'.$request->photo->extension();
        // $request->image->move(public_path('images'), $imageName);

        $check=$this->createAuction($data,$name);
        $users=User::where('status','active')->get();
        // dd($currentURL);

        Notification::send($users, new StatusNotificationToUser( $check));
        Session::put('auction_code',$data['code']);
        // $status=Auction::create($data);

        if($check){


                request()->session()->flash('success','Auction Successfully added');
                return redirect()->route('post.index');

        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        // return redirect()->route('post.index');
    }
    public function createAuction(array $data,$name){

       $au = Auction::create([
            'code'=>$data['code'],
            'title'=>$data['title'],
            'category_id'=>$data['category_id'],
            'description'=>$data['description'],
            'startDate'=>$data['startDate'],
            // 'openedTime'=>$data['openedTime'],
            'endDate'=>$data['endDate'],
            'min_price'=>$data['min_price'],
            'type'=>$data['type'],
            'purpose'=>$data['purpose'],
            'collateral_percent'=>$data['collateral_percent'],
            // 'status'=>$data['status'],
            'user_id'=>auth()->id()


            ]);

            if($name){
                $au->photo=$name;
                $au->save();

            }
            return $au;
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
        $post=Auction::findOrFail($id);
        $categories=PostCategory::where('id',$post->category_id)->first();
        // $tags=PostTag::get();
        $users=User::get();
        return view('user.auction.edit')->with('categories',$categories)->with('users',$users)->with('post',$post);
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
        // $post=Auction::findOrFail($id);
        //   $request->all();
         $validatedData=$request->validate([
            'code'=>'required',
            'title'=>'required',
            'category_id' =>'required',
            'description'=>'required',
            'startDate'=>'required',
            // 'openedTime'=>'required',
            'endDate' => 'required',
            'min_price'=>'nullable',
            'photo'=>'nullable',
            'type'=>'required',
            'purpose'=>'required',
            'collateral_percent'=>''
            // 'status'=>'required|in:active,inactive'
        ]);
        $data=$request->all();
        $check=Auction::whereId($id)->update($validatedData);
        // return $check;

        $name=null;
        if($request->hasFile('photo')){
        //     $destnation_path='public/images/products';
            $file=$request->file('photo');
        $name = Str::random(5).time().'.'.$file->extension();
           $file->move(public_path().'/images/products/', $name);
           $data['photo']=$name;
        }
        $validatedData['user-id']=auth()->id();
       $validatedData['photo']=$name;
        // $check=$this->updateAuction($data);
        // return $data;

        // $status=$post->fill($data)->save();
        if($name){
            $check->photo=$name;
            $check->save();

        }
        if($check){
            request()->session()->flash('success','Auction Successfully updated');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('post.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post=Auction::findOrFail($id);

        $status=$post->delete();

        if($status){
            request()->session()->flash('success','Auction successfully deleted');
        }
        else{
            request()->session()->flash('error','Error while deleting Auction ');
        }
        return redirect()->route('post.index');
    }
    public function auctioLists()
    {
        $auctions=Auction::orderBy('created_at','ASC')->paginate(5);
        return view('user.auction.auction_list')->with('auctions',$auctions);
    }
}
