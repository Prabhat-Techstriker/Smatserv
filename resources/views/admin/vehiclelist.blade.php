@extends('layouts.admin.pages')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Vehicle List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Vehicle List</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                             <div class="card-body">
                              <div class="form-group">
                                <form id="form" method="get" action="">
                                    <label>Select</label>
                                    <select class="form-control" name="vehiclecategory" id="vehiclecategory">
                                      <!-- <option>Select</option> -->
                                      <option value="2" {{ $queryParam == '' || $queryParam == 2  ? 'selected' : ''}}>Courier</option>
                                      <option value="1" {{ $queryParam == 1 ? 'selected' : ''}}>Towing</option>
                                      <option value="3" {{ $queryParam == 3 ? 'selected' : ''}}>Haulage</option>
                                    </select>
                                    <button type="submit" class="btn btn-success">Submit</button>
                                    <!-- <div class="card-footer">
                                      
                                    </div> -->
                                </form>
                              </div>
                            </div>
                            <table id="vehicleTable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Service vehicle</th>
                                        <th>Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   @foreach ($list as $lists)
                                        <tr>
                                            <td>{{$lists->service}}</td>
                                            <td>{{$lists->price}}</td>
                                            <td id="status_{{$lists->id}}">
                                                <?php 
                                                    if ($lists->service != 'Other') {
                                                ?>
                                                    <span><a href="{{url('admin/list-edit/'.$lists->id.'')}}"><i class="fas fa-edit"></i></a></span><span ><a href="javascript:" onClick="deleteList({{$lists->id}})"><i class="far fa-trash-alt"></i></a>
                                                    </span>
                                                <?php
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                    
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection
