@extends('layouts.admin.pages')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <!-- <h1>General Form</h1> -->
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Vehicle</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
   
          <div class="col-md-12">

            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Vehicle</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="myform" method="post" action="{{url('admin/edit')}}">
                {{ csrf_field() }}
                <div class="card-body">
                   <div class="form-group">
                    <label for="vehicle">vehicle name</label>
                    <input type="text" class="form-control" name="vehicle" id="vehicle" placeholder="vehicle" value="{{$vehicle->service}}">
                    <input type="hidden" class="form-control" name="id" id="vehicle_id" value="{{$vehicle->id}}">
                  </div>

                  <div class="form-group">
                    <label for="vehicle">Price</label>
                    <input type="text" class="form-control" name="price" id="price" placeholder="price" value="{{$vehicle->price}}">
                  </div>
                  
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-success">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
@endsection
