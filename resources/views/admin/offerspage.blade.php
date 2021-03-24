@extends('layouts.admin.pages')

@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Offers</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Offers</li>
          </ol>
        </div>
      </div>
    </div>
  </section>
  <section class="content">
    @if ( Session::has('flash_message') )
        <div class="alert {{ Session::get('flash_type') }}" id="flash_message_alert">
            <h3>{{ Session::get('flash_message') }}</h3>
        </div>
    @endif
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title">Send offers</h3>
            </div>
            <div class="card-body">
              <form role="form" action="{{url('admin/offers')}}" enctype="multipart/form-data" method="post"> 
                {{ csrf_field() }} 
                <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Send To</label>
                        <select class="custom-select" required="required" name="sendto">
                          <option>Select</option>
                          <option value="1">User</option>
                          <option value="2">Providers</option>
                          <option value="0">All</option>
                        </select>
                      </div>
                    </div>
                  </div>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Title</label>
                      <input type="text" class="form-control" placeholder="Enter ..." name="title" id="title">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Textarea</label>
                      <textarea class="form-control" rows="3" placeholder="Enter ..." name="textarea" id="textarea"></textarea>
                    </div>
                  </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection