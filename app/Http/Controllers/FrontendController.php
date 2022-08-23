<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use App\Models\PostCategory;
use App\Models\Auction;
use App\User;
use App\SolledDocument;
use App\SupplierList;
use App\Notifications\StatusNotification;
use App\Notifications\NewUserNotification;
use Auth;
use Session;
use DB;
use Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use App\Mail\EmailverificationMail;
use Illuminate\Notifications\Notification;
class FrontendController extends Controller
{

    public function index(Request $request){
        return redirect()->route($request->user()->role);
    }
    public function aboutUs(){
        return view('frontend.pages.about-us');
    }

    public function contact(){
        return view('frontend.pages.contact');
    }
    public function service(){
        return view('frontend.pages.services');
    }

    public function freeAuctionblog(){
        $post=Auction::where('status','active')->where('type','free')->orderBy('created_at','DESC')->get();

        if(!empty($_GET['category'])){
            $slug=explode(',',$_GET['category']);
            // dd($slug);
            $cat_ids=PostCategory::select('id')->whereIn('slug',$slug)->pluck('id')->toArray();
            return $cat_ids;
            $post->whereIn('category_id',$cat_ids);
            // return $post;
        }
        if(!empty($_GET['show'])){
            $post=$post->where('status','active')->where('type','free')->orderBy('created_at','DESC')->paginate($_GET['show']);
        }
        else{
            // $post=$post->where('status','active')->where('type','premium')->orderBy('id','DESC')->paginate(9);
        }
        // $post=Post::where('status','active')->paginate(8);
        $rcnt_post=Auction::where('status','active')->where('type','free')->orderBy('created_at','DESC')->limit(3)->get();
        return view('frontend.pages.freeblog')->with('posts',$post)->with('recent_posts',$rcnt_post);
    }

    public function freeblogDetail($slug){
        $post=Auction::getfreePostBySlug($slug);
        $rcnt_post=Auction::where('status','active')->where('type','free')->orderBy('id','DESC')->limit(3)->get();
        // return $post;
        return view('frontend.pages.freeblog_detail')->with('post',$post)->with('recent_posts',$rcnt_post);
    }

    public function freeblogSearch(Request $request){
        // return $request->all();
        $rcnt_post=Post::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        $posts=Post::orwhere('title','like','%'.$request->search.'%')
            ->orwhere('quote','like','%'.$request->search.'%')
            ->orwhere('summary','like','%'.$request->search.'%')
            ->orwhere('description','like','%'.$request->search.'%')
            ->orwhere('slug','like','%'.$request->search.'%')
            ->orderBy('id','DESC')
            ->paginate(8);
        return view('frontend.pages.blog')->with('posts',$posts)->with('recent_posts',$rcnt_post);
    }

    public function freeblogFilter(Request $request){
        $data=$request->all();
        // return $data;
        $catURL="";
        if(!empty($data['category'])){
            foreach($data['category'] as $category){
                if(empty($catURL)){
                    $catURL .='&category='.$category;
                }
                else{
                    $catURL .=','.$category;
                }
            }
        }

        $tagURL="";
        if(!empty($data['tag'])){
            foreach($data['tag'] as $tag){
                if(empty($tagURL)){
                    $tagURL .='&tag='.$tag;
                }
                else{
                    $tagURL .=','.$tag;
                }
            }
        }
        // return $tagURL;
            // return $catURL;
        return redirect()->route('blog',$catURL.$tagURL);
    }

    public function freeblogByCategory(Request $request){
        $post=PostCategory::getBlogByCategory($request->slug);
        $rcnt_post=Post::where('status','active')->where('type','free')->orderBy('created_at','DESC')->limit(3)->get();
        return view('frontend.pages.blog')->where('type','free')->with('posts',$post->post)->with('recent_posts',$rcnt_post);
    }

    public function freeblogByTag(Request $request){
        // dd($request->slug);
        $post=Auction::getBlogByTag($request->slug);
        // return $post;
        $rcnt_post=Post::where('status','active')->where('type','free')->orderBy('created_at','DESC')->limit(3)->get();
        return view('frontend.pages.blog')->with('posts',$post)->with('recent_posts',$rcnt_post);
    }
//end of free auction
    public function blog(){
        // $post=Auction::query();
        // $post=Auction::get()
        $post=Auction::where('status','active')->where('type','premium')->orderBy('created_at','DESC')->paginate(6);


        if(!empty($_GET['category'])){
            $slug=explode(',',$_GET['category']);
            // dd($slug);
            $cat_ids=PostCategory::select('id')->whereIn('slug',$slug)->pluck('id')->toArray();
            return $cat_ids;
            $post->whereIn('category_id',$cat_ids);
            // return $post;
        }

        if(!empty($_GET['show'])){
            $post=$post->where('status','active')->where('type','premium')->orderBy('created_at','DESC')->paginate($_GET['show']);
        }
        else{
            // $post=$post->where('status','active')->where('type','premium')->orderBy('id','DESC')->paginate(9);
        }
        // $post=Post::where('status','active')->paginate(8);
        $rcnt_post=Auction::where('status','active')->where('type','premium')->orderBy('created_at','DESC')->limit(4)->get();
        return view('frontend.pages.blog')->with('posts',$post)->with('recent_posts',$rcnt_post);
    }

    public function blogDetail($slug){
        $post=Auction::getPostBySlug($slug);
        // return auth()->user()->id;
        if(auth()->user()->id){
        $solddoc=SolledDocument::where('user_id',auth()->user()->id)->first();
        // return $solddoc;
        $rcnt_post=Auction::where('status','active')->where('type','premium')->orderBy('created_at','DESC')->limit(4)->get();
        // return $post;
        return view('frontend.pages.blog-detail')->with('post',$post)->with('recent_posts',$rcnt_post)->with('soldocs',$solddoc);
         }
         else {
            return redirect()->back();
         }
         }

    public function blogSearch(Request $request){
        // return $request->all();
        $rcnt_post=Auction::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        $posts=Auction::orwhere('title','like','%'.$request->search.'%')
            ->orwhere('category_id','like','%'.$request->search.'%')
            // ->orwhere('summary','like','%'.$request->search.'%')
            ->orwhere('description','like','%'.$request->search.'%')
            ->orwhere('type','like','%'.$request->search.'%')
            ->orderBy('id','DESC')
            ->paginate(8);
        return view('frontend.pages.blog')->with('posts',$posts)->with('recent_posts',$rcnt_post);
    }

    public function blogFilter(Request $request){
        $data=$request->all();
        // return $data;
        $catURL="";
        if(!empty($data['category_id'])){
            foreach($data['category_id'] as $category){
                if(empty($catURL)){
                    $catURL .='&category='.$category;
                }
                else{
                    $catURL .=','.$category;
                }
            }
        }

        $tagURL="";
        if(!empty($data['tag'])){
            foreach($data['tag'] as $tag){
                if(empty($tagURL)){
                    $tagURL .='&tag='.$tag;
                }
                else{
                    $tagURL .=','.$tag;
                }
            }
        }
        // return $tagURL;
            // return $catURL;
        return redirect()->route('blog',$catURL.$tagURL);
    }

    public function blogByCategory($id){
      $post=Auction::where('category_id',$id)->get();
        $rcnt_post=Auction::where('status','active')->where('type','premium')->orderBy('id','DESC')->limit(3)->get();
        return view('frontend.pages.blog')->with('posts',$post)->with('recent_posts',$rcnt_post);
    }

    public function blogByTag(Request $request){
        // dd($request->slug);
        $post=Post::getBlogByTag($request->title);
        // return $post;
        $rcnt_post=Post::where('status','active')->where('type','premium')->orderBy('id','DESC')->limit(3)->get();
        return view('frontend.pages.blog')->with('posts',$post)->with('recent_posts',$rcnt_post);
    }



    // Login
    public function login(){
        return view('frontend.pages.login');
    }
    public function loginSubmit(Request $request){
        $data= $request->all();
        if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
            Session::put('user',$data['email']);
            request()->session()->flash('success','Successfully login');
            return redirect()->route('home');
        }
        else{
            request()->session()->flash('error','Invalid email and password pleas try again!');
            return redirect()->back();
        }
    }

    public function logout(){
        Session::forget('user');
        Auth::logout();
        request()->session()->flash('success','Logout successfully');
        return back();
    }

    public function register(){
        return view('frontend.pages.register');
    }
    public function verfiy_email($verification_code){
        $user = User::where('verfication_code',$verification_code )->first();
    }
    public function registerSubmit(Request $request){
        // return $request->all();
        $this->validate($request,[
            'fname'=>'string|required|min:2|max:30',
            'lname'=>'string|required|min:2|max:30',
            'gname'=>'string|required|min:2|max:30',
            'email'=>'string|required|unique:users,email',
            'user_name'=>'string|required|min:2|unique:users',
            'password'=>'required|min:6|confirmed',
            'gender'=>'required',
            'phone'=>'string|required',
            'tin_number'=>'nullable',
            'company_name'=>'nullable',


        ]);


       $data=$request->all();
        // dd($data);
        // return $request->tin_number;
        if($request->tin_number!=null){
            $tin=$this->checktinNumber($request->tin_number);
            if($tin){
              $check=$this->create($data);
              $admin= User::where('role','admin')->first();
              $admin->notify(new NewUserNotification($check));
              Session::put('user',$data['email']);
              if($check){
                  request()->session()->flash('success','Successfully registered');
                 // Mail::to($data['email'])->send(new EmailverificationMail($data));
                  return redirect()->route('login.form');
              }
              else{
                  request()->session()->flash('error','Please try again!');
                  return back();
              }
            }
              else{
                request()->session()->flash('error','Please enter the corret tin number !');
                return back();
              }
        }
        else{
            $check=$this->create($data);

           $admin= User::where('role','admin')->first();
           $admin->notify(new NewUserNotification($check));


              Session::put('user',$data['email']);
              if($check){
                  request()->session()->flash('success','Successfully registered');
                 // Mail::to($data['email'])->send(new EmailverificationMail($data));
                  return redirect()->route('login.form');
              }
              else{
                  request()->session()->flash('error','Please try again!');
                  return back();
              }

        }


    }
    public function create(array $data){
        return User::create([
            'name'=>$data['fname']. " ".$data['lname']." ".$data['gname'] ,
            'email'=>$data['email'],
            'user_name'=>$data['user_name'],
            'password'=>Hash::make($data['password']),
            'gender'=>$data['gender'],
            'phone' =>$data['phone'],
            'tin_number'=>$data['tin_number'],
            'company_name'=>$data['company_name'],
            'verfication_code'=> Str::random(40)

            ]);

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
    // Reset password
    public function showResetForm(){
        return view('auth.passwords.old-reset');
    }
}
