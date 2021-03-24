@extends('layouts.admin.pages')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Advertisement</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Advertisement List</li>
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
            <div class="card card-primary">
              <form method="post" action="{{url('admin/advertiseupload')}}" enctype="multipart/form-data">
                {{ csrf_field() }} 
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="customFile" id="customFile" required="required">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                        <!-- @if($errors->has('firstname'))
                          <div class="error">{{ $errors->first('customFile') }}</div>
                        @endif -->
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
</div>
@endsection
