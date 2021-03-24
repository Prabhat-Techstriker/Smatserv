@extends('layouts.admin.pages')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Providers List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Providers List</li>
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
                        <!-- <div class="card-header">
                            <h3 class="card-title">DataTable with minimal features & hover style</h3>
                        </div>
                        /.card-header -->
                        <div class="card-body">
                            <table id="example3" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Provider Picture</th>
                                        <th>Provider Name</th>
                                        <th>Provider Email</th>
                                        <th>Phone Number</th>                                          
                                        <th>Type</th>
                                        <th>Latitude</th>
                                        <th>Longitude</th>
                                        <th>Address</th> 
                                        <th>Service Type</th> 
                                        <th>Vehicle Type</th> 
                                        <th>Vehicle Number</th> 
                                        <th>Type Of Mechanic</th> 
                                        <th>Courier Type</th>
                                        <th>Haulage Type</th>
                                        <th>Rate Per Hour</th>
                                        <th>Identification Document</th>
                                        <th>Bussiness Certificate</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($providers as $user)
                                        <tr>
                                            <td><img src="{{$user->profile_picture ? $user->profile_picture : 'https://i.ibb.co/hywpmgj/no-image-icon-6.png'}}" alt=""></td>
                                            <td>{{$user->name}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>{{$user->phone_number ? $user->phone_number : '-'}}</td>
                                            <td id="change_status_{{$user->id}}"><span class="badge {{$user->service_type == 1 ? 'badgeWarning' : 'badgePrimary'}}">{{$user->service_type == 1 ? 'User' : 'Provider'}}</span></td>
                                            <td>{{$user->latitude}}</td>
                                            <td>{{$user->longitude}}</td>
                                            <td>{{$user->address}}</td>
                                            <td>{{isset($user->user_details->service_provide_type) ? $user->user_details->service_provide_type : ''}}</td>
                                            <td>{{isset($user->user_details->vehicle_type) ? $user->user_details->vehicle_type : ''}}</td>
                                            <td>{{isset($user->user_details->vehicle_number) ? $user->user_details->vehicle_number : ''}}</td>
                                            <td>{{isset($user->user_details->type_of_mechanic) ? $user->user_details->type_of_mechanic : ''}}</td>
                                            <td>{{isset($user->user_details->courier_type) ? $user->user_details->courier_type : '' }}</td>
                                            <td>{{isset($user->user_details->haulage_type) ? $user->user_details->haulage_type : ''}}</td>
                                            <td>{{isset($user->user_details->rate_per_hour) ? $user->user_details->rate_per_hour : ''}}</td>
                                            <td><img src="https://admin.smatserv.com/storage/app/{{isset($user->user_details->identification_document) ?  $user->user_details->identification_document : 'https://i.ibb.co/hywpmgj/no-image-icon-6.png'}}" alt=""></td>
                                            <td><img src="https://admin.smatserv.com/storage/app/{{isset($user->user_details->bussiness_certificate) ? $user->user_details->bussiness_certificate : 'https://i.ibb.co/hywpmgj/no-image-icon-6.png' }}" alt=""></td>
                                            @if($user->service_type == 1)
                                                <td><span class="">-</span></td>
                                            @else
                                                <td><span class="badge {{$user->admin_approved ? 'badgeInfo' : 'badgeSecondary'}}">{{$user->admin_approved ? 'Approve' : 'Pending'}}</span></td>
                                            @endif
                                            <td>{{$user->created_at->format('m-d-Y')}}</td>
                                            <td>{{$user->updated_at->format('m-d-Y')}}</td>
                                            <td class="change_status_{{$user->id}}"><a id="{{$user->id}}" href="javascript:" onclick="delete_user(this.id)" data-id="{{$user->id}}"><i class="far fa-trash-alt"></i></a></td>
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
