@extends('layouts.admin.pages')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Rating-Review List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Rating-Review List</li>
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
                                        <th>Id</th>
                                        <th>Provider Name</th>
                                        <th>Provider Type</th>
                                        <th>User Name</th>
                                        <th>Rating</th>
                                        <th>Review text</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($results as $data)
                                        <tr>                                            
                                            <td>{{isset($data->id) ? $data->id : ''}}</td>                                            
                                            <td>{{isset($data->provider->name) ? $data->provider->name : ''}}</td>
                                            <td>{{isset($data->provider_details->service_provide_type) ? $data->provider_details->service_provide_type : ''}}</td>
                                            <td>{{isset($data->user->name) ? $data->user->name : ''}}</td>
                                            <td>{{isset($data->rating) ? $data->rating : ''}}</td>
                                            <td>{{isset($data->description) ? $data->description : ''}}</td>
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
