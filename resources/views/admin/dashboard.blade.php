@extends('layouts.admin.dashboard')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ $providersApprovalList }}</h3>
                <p>Providers Approval List</p>
              </div>
              <!-- <div class="icon">
                <i class="ion ion-bag"></i>
              </div> -->
              <a href="{{url('admin/providers-list')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{ $usersprovidersList }}</h3>
                <p>Users-Providers List</p>
              </div>
              <!-- <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div> -->
              <a href="{{url('admin/all-users-list')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ $paymentInfoList }}</h3>
                <p>Payment Info List</p>
              </div>
              <!-- <div class="icon">
                <i class="ion ion-person-add"></i>
              </div> -->
              <a href="{{url('admin/payment-info')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ $vehiclePriceList }}</h3>
                <p>Vehicle Price List</p>
              </div>
              <!-- <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div> -->
              <a href="{{url('admin/vehicle-list')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection