@extends('user.layouts.master')

@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary float-left">Auction Document Lists</h6>
      <a href="{{route('document.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add Document"><i class="fas fa-plus"></i> Add Document</a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <!--

id
auction_name
category
description
startDate
endDate
status
min_price
photo
openedTime
auctioneer_id
winner_id
created_at
updated_at -->
        @if(count($documents)>0)
        <table class="table table-bordered" id="product-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>#</th>
              <th>Auction_code</th>
              <th>Product_name</th>
              {{-- <th>product_type</th>
              <th>product_measure</th> --}}
              <th>Product_amount</th>
              <th>Product_price</th>
              <th>Action</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>#</th>
              <th>Auction_code</th>
              <th>Product_name</th>
              {{-- <th>product_type</th> --}}
              {{-- <th>product_measure</th> --}}
              <th>Product_amount</th>
              <th>Product_price</th>
              <th>Action</th>
            </tr>
          </tfoot>
          <tbody>


            @foreach($documents as $document)
              @php
              $author_info=DB::table('users')->select('name')->where('id',$document->user_id)->get();
              $auctions=DB::table('auctions')->select('code')->where('id',$document->auction_id)->get();
              // dd($sub_cat_info);
              // dd($author_info);
            //   dd($auction_code);

              @endphp
                <tr>
                    {{-- {{@foreach($auctions as $auction ) $auction->code @endforeach}} --}}

                    <td>{{$document->id}}</td>
                    <td>
                        @foreach($auctions as $data)
                        @if($data->code)
                            {{$data->code}}
                        @else
                            Anonymous
                        @endif
                    @endforeach
                    </td>
                    <td>{{$document->product_name}}</td>
                    {{-- <td>{{$document->product_type}}</td>
                    <td>{{$document->product_measure}}</td> --}}
                    <td>{{$document->product_amount}}</td>
                    <td>{{$document->product_price}}</td>
                    {{-- <td>{{$document->cat_info->title}}</td> --}}



                    {{-- <td>
                        @if($document->photo)
                            <img src="{{$post->photo}}" class="img-fluid zoom" style="max-width:80px" alt="{{$post->photo}}">
                        @else
                            <img src="{{asset('backend/img/thumbnail-default.jpg')}}" class="img-fluid" style="max-width:80px" alt="avatar.png">
                        @endif
                    </td>                    --}}
                    {{-- <td>
                        @if($post->status=='active')
                            <span class="badge badge-success">{{$post->status}}</span>
                        @else
                            <span class="badge badge-warning">{{$post->status}}</span>
                        @endif
                    </td> --}}
                    <td>
                        <a href="{{route('document.edit',$document->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                    <form method="POST" action="{{route('document.destroy',[$document->id])}}">
                      @csrf
                      @method('delete')
                          <button class="btn btn-danger btn-sm dltBtn" data-id={{$document->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
          </tbody>
        </table>
          {{$documents->links()}}

        {{-- <span style="float:right">{{$documents->links()}}</span> --}}
        @else
          <h6 class="text-center">No documents found!!! Please create document</h6>
        @endif
      </div>
    </div>
</div>
@endsection

@push('styles')
  <link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
  <style>
      div.dataTables_wrapper div.dataTables_paginate{
          display: none;
      }
      .zoom {
        transition: transform .2s; /* Animation */
      }

      .zoom:hover {
        transform: scale(5);
      }
  </style>
@endpush

@push('scripts')

  <!-- Page level plugins -->
  <script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
  <script>

      $('#product-dataTable').DataTable( {
            "columnDefs":[
                {
                    "orderable":false,
                    "targets":[8,9,10]
                }
            ]
        } );

        // Sweet alert

        function deleteData(id){

        }
  </script>
  <script>
      $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
          $('.dltBtn').click(function(e){
              var form=$(this).closest('form');
              var dataID=$(this).data('id');
              // alert(dataID);
              e.preventDefault();
              swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                       form.submit();
                    } else {
                        swal("Your data is safe!");
                    }
                });
          })
      })
  </script>
@endpush
