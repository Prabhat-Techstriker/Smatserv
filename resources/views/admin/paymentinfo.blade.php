@extends('layouts.admin.pages')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Payment List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Payment List</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="example4" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Payment Id</th>
                                        <th>User Name</th>
                                        <th>User Email</th>
                                        <th>Provider Name</th>
                                        <th>Provider Type</th>
                                        <th>Provider Email</th>
                                        <th>Provider Phone Number</th>
                                        <th>Payment Amount</th>
                                        <th>Booking Id</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($paymentinfo as $data)
                                        <tr>                                            
                                            <td>{{isset($data->payment_ref_id) ? $data->payment_ref_id : ''}}</td>
                                            <td>{{isset($data->user->name) ? $data->user->name : ''}}</td>
                                            <td>{{isset($data->user->email) ? $data->user->email : ''}}</td>
                                            <td>{{isset($data->provider->name) ? $data->provider->name : ''}}</td>
                                            <td>{{isset($data->provider->name) ? $data->user_details->service_provide_type : ''}}</td>
                                            <td>{{isset($data->provider->email) ? $data->provider->email : ''}}</td>
                                            <td>{{isset($data->provider->phone_number) ? $data->provider->phone_number : ''}}</td>
                                            <td>{{isset($data->price) ? $data->price : ''}}</td>
                                            <td>smatserv_{{isset($data->booking_id) ? $data->booking_id : ''}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                    
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
