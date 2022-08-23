@extends('frontend.layouts.master')

@section('title','OAS| About Us')

@section('main-content')

	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="index1.html">Home<i class="ti-arrow-right"></i></a></li>
							<li class="active"><a href="blog-single.html">About Us</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- About Us -->
	<section class="about-us section">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 col-12">
						<div class="about-content">
							@php
								$settings=DB::table('settings')->get();
							@endphp
							<h3>Welcome To <span>OUR OAS</span></h3>
							<p>@foreach($settings as $data) {{$data->description}} @endforeach</p>
							<div class="button">
								<a href="{{route('blog')}}" class="btn">Our Blog</a>
								<a href="{{route('contact')}}" class="btn primary">Contact Us</a>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-12">
						<div class="about-img overlay">
							{{-- <div class="button">
							</div> --}}
                            <img src="{{asset('/photos/2/20220625_080717.jpg')}}" alt="image of me" width="250px" height="600px">
						</div>
					</div>
				</div>
			</div>
	</section>
	<!-- End About Us -->

	<section class="shop-services section">
		<div class="container">
			<h1 style="color: #ffde20;" class="justify-content-center">Developers</h1>
			<div class="row">
				<div class="col-xl-4 col-lg-5">
					<div class="card shadow mb-4">
					  <!-- Card Header - Dropdown -->
					  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
						<h6 class="m-0 font-weight-bold text-primary">HABTAMU YIHUN</h6>
					  </div>
					  <!-- Card Body -->
					  <div class="card-body" style="overflow:hidden">
						<div id="pie_chart" style="width:350px; height:320px;">
							<img src="{{asset('/photos/2/20220625_080717.jpg')}}" alt="image of me" width="150px" height="80px" style="border-radius:60px">
							<p>«Sed ut perspiciatis unde omnis
								iste natus error sit voluptatem
								accusantium doloremque laudantium,
								 totam rem aperiam eaque ipsa, quae eius modi tempora incidunt, ut labore
                                 <a href=""class="btn btn-primary btn-sm float-left mr-1"  data-toggle="tooltip" title="download" data-placement="bottom">See More</a>
                                </p>
					  </div>
					</div>
				  </div>
				</div>
				<div class="col-xl-4 col-lg-5">
					<div class="card shadow mb-4">
					  <!-- Card Header - Dropdown -->
					  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
						<h6 class="m-0 font-weight-bold text-primary">BELSTI YEZENGAW</h6>
					  </div>
					  <!-- Card Body -->
					  <div class="card-body" style="overflow:hidden">
						<div id="pie_chart" style="width:350px; height:320px;">
							<img src="{{asset('/photos/2/photo_2022-06-20_16-29-09.jpg')}}" alt="image of me" width="150px" height="80px" style="border-radius:60px">
							<p>«Sed ut perspiciatis unde omnis
								iste natus error sit voluptatem
								accusantium doloremque laudantium,
								 totam rem aperiam eaque ipsa, quae eius modi tempora incidunt, ut labore
                                 <a href=""class="btn btn-primary btn-sm float-left mr-1"  data-toggle="tooltip" title="download" data-placement="bottom">See More</a>
                                </p>
					  </div>
					</div>
				  </div>
				</div>
				<div class="col-xl-4 col-lg-5">
					<div class="card shadow mb-4">
					  <!-- Card Header - Dropdown -->
					  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
						<h6 class="m-0 font-weight-bold text-primary">FIKRESELAM AYELE</h6>
					  </div>
					  <!-- Card Body -->
					  <div class="card-body" style="overflow:hidden">
						<div id="pie_chart" style="width:350px; height:320px;">
							<img src="{{asset('/photos/2/photo_2022-06-22_09-28-26 (2).jpg')}}" alt="image of me" width="150px" height="80px" style="border-radius:60px">
							<p>«Sed ut perspiciatis unde omnis
								iste natus error sit voluptatem
								accusantium doloremque laudantium,
								 totam rem aperiam eaque ipsa, quae
								  eius modi tempora incidunt, ut labore
                                  <a href="" class="btn btn-light btn-sm float-left mr-1"  data-toggle="tooltip" title="download" data-placement="bottom">See More</a>
                                </p></p>
					  </div>
					</div>
				  </div>
				</div>
			</div>
		</div>
	</section>
@endsection
