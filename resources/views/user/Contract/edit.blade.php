@extends('user.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Edit Contract</h5>
    <div class="card-body">
      <form method="post" action="{{route('contract.update',$contract->id)}}">
        @csrf
        @method('PATCH')
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Title <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="title" placeholder="Enter title"  value="{{$contract->title}}" class="form-control">
          @error('title')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="description" class="col-form-label">Description</label>
          <textarea class="form-control" id="description" name="description"value={!! html_entity_decode( $contract->description)!!}></textarea>
          @error('description')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
            <label for="post_cat_id">Auction <span class="text-danger">*</span></label>
            <select name="auction_id" class="form-control">

                {{-- <option value=''>{{$auctions->title}}</option>
                @foreach($auctions as $key=>$data) --}}
                    {{-- <option value='{{$data->auction_id}}'>{{$data->title.' code:'.$data->code}}</option> --}}
                {{-- @endforeach --}}



            </select>
        </div>
            <div class="form-group mb-3">
                {{-- <button type="reset" class="btn btn-warning">Reset</button> --}}
                 <button class="btn btn-success" type="submit">Update</button>

          </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />

@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script>
    $('#lfm').filemanager('image');

    $(document).ready(function() {
    $('#summary').summernote({
      placeholder: "Write short description.....",
        tabsize: 2,
        height: 150
    });
    });

    $(document).ready(function() {
      $('#quote').summernote({
        placeholder: "Write short Quote.....",
          tabsize: 2,
          height: 100
      });
    });
    $(document).ready(function() {
      $('#description').summernote({
        placeholder: "Write detail description.....",
          tabsize: 2,
          height: 150
      });
    });
</script>
@endpush
