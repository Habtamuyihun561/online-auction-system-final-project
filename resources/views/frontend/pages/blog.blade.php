@extends('frontend.layouts.master')
<?php
use Carbon\Carbon;
?>

@section('title','AUS | Home Page')

@section('main-content')
{{-- @if($posts) --}}
<div class="container-fluid bg-white mr-0" >
    <div class="container">

        @foreach ($posts as $image)
        <div class="mySlides slider">
            <img class='ml-5' src="{{asset('./images/products/'.$image->photo)}}"  style="width: 90%; height:350px" alt="Slide Show">
        </div>
        @endforeach
        <a class="prev" onclick="plusSlides(-1)">❮</a>
        <a class="next" onclick="plusSlides(1)">❯</a>
    </div>

</div>
<div class="container-fluid bg-white ml-0">
    <h3 style="color: #ff9216; justify-content:center;padding-left:30%; padding-top:10px">Thanks For Being User of Our System</h3>
    <h5 style="color: #ff9216;padding-left:32%;padding-top:15px">New Auctions Are Always Availabele Here !!</h5>
</div>
    <!-- Breadcrumbs -->
    <!-- <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                     <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0);">Auction Grid Sidebar</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- End Breadcrumbs -->

    <!-- Start Blog Single -->
    <section class="blog-single shop-blog grid section">
        <div class="container" >
            <div class="row ml-0">
                <div class="col-lg-8 col-12 ml-0">
                    <div class="row ml-0">
                        @foreach($posts as $post)
                        {{-- {{$post}} --}}
                            <div class="col-lg-6 col-md-6 col-12 ml-0">
                                <!-- Start Single Blog  -->

                                 <div class="shop-single-blog ml-0">
                                    @if($post->photo)
                                        <img src="{{asset('/images/products'.'/'.$post->photo)}}" alt="{{asset('/images/products'.'/'.$post->photo)}}">
                                     @else
                                    @endif

                                    <div class="content" style="text-align:left;" style="height: 200px;">
                                        @php
                                            $author_info=DB::table('users')->select('name')->where('id',$post->user_id)->get();
                                        @endphp
                                      <p class="date"><i class="fa fa-calendar" aria-hidden="true"></i> {{$post->created_at->format('d M, Y. D')}}
                                            <span class="float-right">
                                                <i class="fa fa-user" aria-hidden="true"></i>
                                                @foreach($author_info as $data)
                                                    @if($data->name)
                                                        {{$data->name}}
                                                    @else
                                                        Anonymous
                                                     @endif
                                                @endforeach
                                            </span>
                                        </p>
                                        @if(Auth::check())
                                        <a href="{{route('blog.detail',$post->id)}}" class="title">{{$post->title}}</a>
                                        @else
                                        <a href="{{route('login.form')}}" class="title">{{$post->title}}</a>
                                    @endif
                                         <p class="two_chars large"> {!! html_entity_decode( Str::limit($post->description, 400))!!} </p>

                                         @if(Auth::check())
                                          <a href="{{route('blog.detail',$post->id)}}" class="more-btn"><span> View Detail</span></a>
                                        @else
                                            <a href="{{route('login.form')}}" class="more-btn">View Detail</a>
                                        @endif

                                        <hr>
                                        <p>Ende date: <i style="color: red;"> {{ Carbon::createFromFormat('Y-m-d',$post->endDate)->format('d M, Y. D') }} </i> </p>
                                        @if($post->min_price!='')
                                        <p>Intial price:  <b>{{ $post->min_price}} Birr </b></p>
                                        <p>Auction Code  <b>{{ $post->code}} </b></p>
                                        @else
                                        @endif
                                        @if(Auth::check())
                                            <a href="{{route('blog.detail',$post->id)}}" class="more-btn">Continue Reading</a>

                                        @else
                                            <a href="{{route('login.form')}}" class="more-btn">Continue Reading</a>


                                         @endif

                                    </div>
                                </div>

                                <!-- End Single Blog  -->
                            </div>
                        @endforeach
                        <div class="col-12">
                            <!-- Pagination -->
                            {{-- {{$posts->appends($_GET)->links()}} --}}
                            <!--/ End Pagination -->
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-12">
                    <div class="main-sidebar">
                        <!-- Single Widget -->
                        <div class="single-widget search">
                            <form class="form" method="GET" action="{{route('blog.search')}}">
                                <input type="text" placeholder="Search Here..." name="search">
                                <button class="button" type="sumbit"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                        <!--/ End Single Widget -->
                        <!-- Single Widget -->
                        <div class="single-widget category">
                            <h3 class="title">Auction Categories</h3>
                            <ul class="categor-list">
                                @if(!empty($_GET['category']))
                                    @php
                                        $filter_cats=explode(',',$_GET['category']);
                                    @endphp
                                @endif
                            <form action="{{route('blog.filter')}}" method="POST">
                                    @csrf
                                    {{-- {{count(Helper::postCategoryList())}} --}}
                                    @foreach(Helper::postCategoryList('posts') as $cat)
                                    <li>
                                        <a href="{{route('blog.category',$cat->id)}}">{{$cat->title}} </a>
                                    </li>
                                    @endforeach
                                </form>

                            </ul>
                        </div>
                        <!--/ End Single Widget -->
                        <!-- Single Widget -->
                        <div class="single-widget recent-post">
                            <h3 class="title">Recent Auction</h3>
                            @foreach($recent_posts as $post)
                                <!-- Single Post -->
                                <div class="single-post">
                                    <div class="image">
                                        @if($post->photo)
                                        <img src="{{asset('/images/products'.'/'.$post->photo)}}" alt="{{asset('/images/products'.'/'.$post->photo)}}">
                                     @else
                                    @endif
                                    </div>
                                    <div class="content">
                                        <h5><a href="#">{{$post->title}}</a></h5>
                                        <ul class="comment">
                                        @php
                                            $author_info=DB::table('users')->select('name')->where('id',$post->user_id)->get();
                                        @endphp
                                            <li><i class="fa fa-calendar" aria-hidden="true"></i>{{$post->created_at->format('d M, y')}}</li>
                                            <li><i class="fa fa-user" aria-hidden="true"></i>
                                                @foreach($author_info as $data)
                                                    @if($data->name)
                                                        {{$data->name}}
                                                    @else
                                                        Anonymous
                                                    @endif
                                                @endforeach
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- End Single Post -->
                            @endforeach
                        </div>
                        <!--/ End Single Widget -->
                        <!-- Single Widget -->
                        <!--/ End Single Widget -->
                        <!-- Single Widget -->

                        <!--/ End Single Widget -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Blog Single -->
@endsection
@push('styles')
    <style>
        .pagination{
            display:inline-flex;
        }
        .two_chars{
        font-family: monospace;
        width: 2ch;
        overflow: hidden;
        white-space: nowrap;
        }

        .large{
        font-size: 2em;
        }
        .show-read-more .more-text{
        display: none;
    }

    @keyframes slider {
       0%{
        left: 0;
    }
     20%{
        left: 0%;
    }
    25%{
        left: -100%;
    }
    45% {
        left: -100%;
    }
    50% {
        left: -200%;
    }
    70% {
        left: -200%;
    }
}
    /* body {

    font-family: Arial;
  margin: 0;
} */

* {
  box-sizing: border-box;
}

img {
  vertical-align: middle;
  width:100px;
  height:100px;
}

/* Position the image container (needed to position the left and right arrows) */
.container {
  position: relative;
}

/* Hide the images by default */
.mySlides {
  display: none;
}

/* Add a pointer when hovering over the thumbnail images */
.cursor {
  cursor: pointer;
}

/* Next & previous buttons */
.prev,
.next {
  cursor: pointer;
  position: absolute;
  top: 40%;
  width: auto;
  padding: 16px;
  margin-top: -50px;
  color: white;
  font-weight: bold;
  font-size: 20px;
  border-radius: 0 3px 3px 0;
  user-select: none;
  -webkit-user-select: none;
}

/* Position the "next button" to the right */
.next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover,
.next:hover {
  background-color: rgba(0, 0, 0, 0.8);
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 10px;
  position: absolute;
  top: 0;
}

/* Container for image text */
.caption-container {
  text-align: center;
  background-color: #222;
  padding: 2px 16px;
  color: white;
}

.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Six columns side by side */
.column {
  float: left;
  width: 16.66%;
}

/* Add a transparency effect for thumnbail images */
.demo {
  opacity: 0.6;
}

.active,
.demo:hover {
  opacity: 1;
}
    </style>
    @endpush
    @push('scripts')
    <script>

let slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  let dots = document.getElementsByClassName("demo");
  let captionText = document.getElementById("caption");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
  captionText.innerHTML = dots[slideIndex-1].alt;
}


        $(document).ready(function(){
            var maxLength = 200;
            $(".show-read-more").each(function(){
                var myStr = $(this).text();
                if($.trim(myStr).length > maxLength){
                    var newStr = myStr.substring(0, maxLength);
                    var removedStr = myStr.substring(maxLength, $.trim(myStr).length);
                    $(this).empty().html(newStr);
                    $(this).append(' <a href="javascript:void(0);" class="read-more">read more...</a>');
                    $(this).append('<span class="more-text">' + removedStr + '</span>');
                }
            });
            $(".read-more").click(function(){
                $(this).siblings(".more-text").contents().unwrap();
                $(this).remove();
            });
        });
        </script>
         <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
@endpush
