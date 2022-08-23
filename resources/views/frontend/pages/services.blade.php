@extends('frontend.layouts.master')

@section('main-content')
	<!-- Breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
							<li class="active"><a href="javascript:void(0);">Service</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Breadcrumbs -->

	<!-- Start Contact -->
	<section id="contact-us" class="contact-us section bg-white mb-1">
		<div class="container">

				<div class="contact-head">
					<div class="row">
                        <div class="col-lg-4 col-12">
                            <div> <h2 style="color: #fba207;" class="justify-content-center">Here You Can Post Auctions</h2></div>
                            <hr>
                            <div>
                                The passage experienced a surge in popularity
                                during the 1960s when Letraset used it on their
                                dry-transfer sheets, and again during the 90s
                                as desktop publishers bundled the text with
                                their software. Today it's seen all around
                                 the web; on templates, websites, and stock
                                 designs. Use our generator to get your own,
                                 or read
                                on for the authoritative history of lorem ipsum.
                             </div>
                             <div class="button">
                                @if(Auth::check())
								<a href="{{route('post.create')}}" class="btn" style="color:white">Post Auctions</a>
                                @else
                                <a href="{{route('login.form')}}" class="btn" style="color:white">Post Auctions</a>
                            @endif
                            </div>
                        </div>

                        <div class="col-lg-4 col-12">
                            <div> <h2 style="color: #fba207;" class="justify-content-center">You can Participate in Diffreent Auctions</h2></div>
                        <hr>
                        <div>
                            The passage experienced a surge in popularity
                            during the 1960s when Letraset used it on their
                            dry-transfer sheets, and again during the 90s
                            as desktop publishers bundled the text with
                            their software. Today it's seen all around
                             the web; on templates, websites, and stock
                             designs. Use our generator to get your own,
                             or read
                            on for the authoritative history of lorem ipsum.
                         </div>
                         @if(Auth::check())
                         <a href="{{route('blog')}}" class="btn" style="color:#ffffff">OUR BLOGS</a>
                         @else
                                <a href="{{route('login.form')}}" class="btn" style="color:#ffffff">OUR BLOGS</a>
                            @endif
                        </div>
                        <div class="col-lg-4 col-12">
                       <div> <h2 style="color: #fba207;" class="justify-content-center">You can pay For Documents Online</h2></div>
                         <hr>
                         <div>
                            The passage experienced a surge in popularity
                            during the 1960s when Letraset used it on their
                            dry-transfer sheets, and again during the 90s
                            as desktop publishers bundled the text with
                            their software. Today it's seen all around
                             the web; on templates, websites, and stock
                             designs. Use our generator to get your own,
                             or read
                            on for the authoritative history of lorem ipsum.
                         </div>
                         @if(Auth::check())
                         <a href="{{route('contact')}}" class="btn success" style="color:#ffffff">Contact Us</a>
                         @else
                         <a href="{{route('login.form')}}" class="btn success" style="color:#ffffff">Contact Us</a>
                     @endif
                        </div>

				</div>
			</div>

	</section>

	<!--================Contact Success  =================-->

	<!-- Modals error -->

@endsection

@push('styles')
<style>
	.modal-dialog .modal-content .modal-header{
		position:initial;
		padding: 10px 20px;
		border-bottom: 1px solid #e9ecef;
	}
	.modal-dialog .modal-content .modal-body{
		height:100px;
		padding:10px 20px;
	}
	.modal-dialog .modal-content {
		width: 50%;
		border-radius: 0;
		margin: auto;
	}
</style>
@endpush
@push('scripts')
<script src="{{ asset('frontend/js/jquery.form.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('frontend/js/contact.js') }}"></script>
@endpush
