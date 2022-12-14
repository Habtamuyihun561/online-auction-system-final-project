@extends('user.layouts.master')

@section('main-content')
<div class="container-fluid">
    @include('user.layouts.notification')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>
     <div class="row">
      {{-- thdiididi --}}
<!-- Category -->
<div class="col-xl-3 col-md-6 mb-4">
  <div class="card border-left-primary shadow h-100 py-2">
    <div class="card-body">
      <div class="row no-gutters align-items-center">
        <div class="col mr-2">
          <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Category</div>
          <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\PostCategory::countActiveCategory()}}</div>
        </div>
        <div class="col-auto">
          <i class="fas fa-sitemap fa-2x text-gray-300"></i>
        </div>
      </div>
    </div>
  </div>
</div>





</div>
<div class="row">

<!-- Area Chart -->
<div class="col-xl-8 col-lg-7">
  <div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Total Auctions you participate</h6>
    </div>
    <div class="h5 mb-0 ml-5 font-weight-bold text-gray-800">{{\App\SubmitedDocuement::countAuction()}}</div>
    <!-- Card Body -->
    <div class="card-body">
      <div class="chart-area">
        <canvas id="myAreaChart" ></canvas>
      </div>
    </div>
  </div>
</div>

<!-- Pie Chart -->
<div class="col-xl-4 col-lg-5">
  <div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Total Auctions You Win</h6>
    </div>
    <div class="h5 mb-0 ml-5 font-weight-bold text-gray-800">{{\App\Winner::countAuction()}}</div>
    <!-- Card Body -->
    <div class="card-body" style="overflow:hidden">
      <div id="pie_chart" style="width:350px; height:320px;">
    </div>
  </div>
</div>
</div>
<!-- Content Row -->

</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
@endpush
