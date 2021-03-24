@extends('layouts.admin.pages')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>All Users-Providers List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">All Users-Providers List</li>
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
                         <!--<div class="card-header">
                            <h3 class="card-title">DataTable with minimal features & hover style</h3>
                        </div>
                        /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Provider Name</th>
                                        <th>Provider Email</th>
                                        <th>Phone Number</th>
                                        <th>Service</th>
                                        <th>Latitude</th>
                                        <th>Longitude</th>
                                        <th>Address</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{$user->name}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>{{$user->phone_number ? $user->phone_number : '-'}}</td>
                                            <td>{{isset($user->user_details->service_provide_type) ? $user->user_details->service_provide_type : ''}}</td>
                                            <td>{{$user->latitude}}</td>
                                            <td>{{$user->longitude}}</td>
                                            <td>{{$user->address}}</td>
                                            <td id="change_status_{{$user->id}}"><span class="badge {{$user->service_type == 1 ? 'badgeWarning' : 'badgePrimary'}}">{{$user->service_type == 1 ? 'User' : 'Provider'}}</span></td>
                                            @if($user->service_type == 1)
                                                <td><span class="">-</span></td>
                                            @else
                                                <td><span class="badge {{$user->admin_approved ? 'badgeInfo' : 'badgeSecondary'}}">{{$user->admin_approved ? 'Approve' : 'Pending'}}</span></td>
                                            @endif
                                            <td class="change_status_{{$user->id}}"><!-- <a href="javascript:"><i class="fas fa-edit"></i></a> -->  <a id="{{$user->id}}" href="javascript:" onclick="delete_user(this.id)" data-id="{{$user->id}}"><i class="far fa-trash-alt"></i></a></td>
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
