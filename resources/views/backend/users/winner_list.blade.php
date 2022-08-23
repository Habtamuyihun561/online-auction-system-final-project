
@extends('backend.layouts.master')
@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4">
     <div class="row">
         <div class="col-md-12">
            {{-- @include('backend.layouts.notification') --}}
         </div>
     </div>
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary float-left"> Winner Users List</h6>
      {{-- <a href="{{route('users.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add User</a> --}}
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="user-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
                <th>S.N.</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Auction Code</th>
                <th>Auction Title</th>
                <th>Category</th>
                <th>Auction Type</th>
                <th>Totla_price</th>
                <th>Action</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>S.N.</th>
              <th>Full Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Auction Code</th>
              <th>Auction Title</th>
              <th>Category</th>
              <th>Auction Type</th>
              <th>Totla_price</th>
              <th>Action</th>
              </tr>
          </tfoot>
          <tbody>
            @foreach($users as $winner)
                <tr>
                    <td>{{$winner->id}}</td>
                    <td>{{$winner->full_name}}</td>
                    <td>{{$winner->email}}</td>
                    <td>{{$winner->phone}}</td>
                    <td>{{$winner->auction_code}}</td>
                    <td>{{$winner->auction_title}}</td>
                    <td>{{$winner->category}}</td>
                    <td>{{$winner->auction_type}}</td>
                    <td>{{$winner->total_price}}</td>
                    @if($winner->user_id==auth()->user()->id)
                        <td><a href=""class="btn btn-primary btn-sm float-left mr-1"  data-toggle="tooltip" title="download" data-placement="bottom">View Contrat</a></td>
                    @else
                    @endif
                </tr>
            @endforeach
          </tbody>
        </table>
         <span style="float:right">{{$users->links()}}</span>
        {{-- <span style="float:right">{{$users->links()}}</span> --}}
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
  </style>
@endpush

@push('scripts')

  <!-- Page level plugins -->
  {{-- <script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script> --}}

  <!-- Page level custom scripts -->
  {{-- <script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script> --}}
  <script>

      $('#user-dataTable').DataTable( {
            "columnDefs":[
                {
                    "orderable":false,
                    "targets":[6,7]
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
