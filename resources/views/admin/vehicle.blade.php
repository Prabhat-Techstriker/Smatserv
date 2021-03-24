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
                <h3 class="card-title">Add Vehicle</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="myform" method="post" action="{{url('admin/add-price')}}">
                {{ csrf_field() }}
                <div class="card-body">
                  <!-- <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                  </div>-->
                  <div class="form-group">
                    <label>Select</label>
                    <select class="form-control" name="category">
                      <option>Select</option>
                      <option value="2">Courier</option>
                      <option value="1">Towing</option>
                      <option value="3">Haulage</option>
                      <!-- <option>option 4</option>
                      <option>option 5</option> -->
                    </select>
                  </div>

                  <div class="row" id="addVehicle">
                    <div class="col-5">
                      <input type="text" class="form-control" name="vehicle[]" placeholder="vehicle" required="required">
                    </div>
                    <div class="col-5">
                      <input type="text" class="form-control" name="price[]" placeholder="price" required="required">
                    </div>
                    <div class="col-2">
                      <button type="button" class="btn btn-primary" id="addDiv">Add</button>
                    </div>
                    <!-- <div class="col-4">
                      <input type="text" class="form-control" placeholder=".col-4">
                    </div>
                    <div class="col-5">
                      <input type="text" class="form-control" placeholder=".col-5">
                    </div> -->
                  </div>

                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-success">Submit</button>
                </div>
              </form>
            </div>

            <!-- <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">Different Width</h3>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-3">
                    <input type="text" class="form-control" placeholder=".col-3">
                  </div>
                  <div class="col-4">
                    <input type="text" class="form-control" placeholder=".col-4">
                  </div>
                  <div class="col-5">
                    <input type="text" class="form-control" placeholder=".col-5">
                  </div>
                </div>
              </div>
            </div> -->
          </div>
          
          <!-- <div class="col-md-6">
            <div class="card card-warning">
              <div class="card-body">
                <form role="form">
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Select</label>
                        <select class="form-control">
                          <option>option 1</option>
                          <option>option 2</option>
                          <option>option 3</option>
                          <option>option 4</option>
                          <option>option 5</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div> -->
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
@endsection
