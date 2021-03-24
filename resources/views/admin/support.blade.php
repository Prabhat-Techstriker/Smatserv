@extends('layouts.admin.pages')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Support Messages List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Support Messages List</li>
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
                            <table id="example4" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>User Name</th>
                                        <th>User Email</th>
                                         <th>Message</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $user)
                                        <tr>
                                            <td>{{$user->user->name}}</td>
                                            <td>{{$user->user->email}}</td>
                                            <td>{{$user->support_text}}</td>
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
