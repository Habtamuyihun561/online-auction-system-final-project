@extends('backend.layouts.master')

@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary float-left">Report Lists</h6>
      {{-- <a href="{{route('postcategory.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add Category</a> --}}
    </div>
    <div class="card-body">
      <div class="table-responsive">
        {{-- @if($auction>0) --}}
        <table class="table table-bordered" id="banner-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>S.N.</th>
              <th>Total Active Users</th>
              <th>Total Active Auctions</th>
              <th>Total Deactivated Auctions</th>
              <th>Total Documents sold</th>
              <th>Total Price Earned</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
                <th>S.N.</th>
                <th>Total Active Users</th>
                <th>Total Active Auctions</th>
                <th>Total Deactivated Auctions</th>
                <th>Total Documents sold</th>
                <th>Total Price Earned</th>
            </tr>
          </tfoot>

          <tbody>
            <tr>
                <td>{{'#'}}</td>
                <td>{{$user}}</td>
                <td>{{$active}}</td>
                <td>{{$deactive}}</td>
                <td>{{$doc}}</td>
                <td>{{$price}}</td>
            </tr>

          </tbody>
        </table>

        {{-- <span style="float:right">{{$postCategories->links()}}</span> --}}
        {{-- @else
          <h6 class="text-center">No Categories found!!! Please create Category</h6>
        @endif --}}
      </div>
      <button class="print-window">Print</button>

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
<script>
    $('.print-window').click(function(){
        window.print();
    });
// var i=1;
// print(i);
// function print(i){
//     if (i <= 10){
//    console.log('Hi');
//      i=i+1;
//      print(i);
//                }
// }
//    window.print();
//    }
   </script>

  <!-- Page level plugins -->
  {{-- <script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script> --}}

  <!-- Page level custom scripts -->
  <script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
  <script>
        // <script type="text/javascript">


      $('#banner-dataTable').DataTable( {
            "columnDefs":[
                {
                    "orderable":false,
                    "targets":[3,4,5]
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
