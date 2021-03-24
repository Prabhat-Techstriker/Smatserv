<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SmatServ</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('public/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css"> -->
  <link rel="stylesheet" href="{{ asset('public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('public/dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/dist/css/summernote-bs4.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css" integrity="sha512-wJgJNTBBkLit7ymC6vvzM1EcSWeM9mmOu+1USHaRBbHkm6W9EgM0HY27+UtUaprntaYQJF75rc8gjxllKs5OIQ==" crossorigin="anonymous" />
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('public/dist/img/logo.png') }}">
</head>
<style type="text/css">
  i.far.fa-trash-alt {
    color: red;
  }

  i.fas.fa-edit {
    color: steelblue;
  }

  div#example1_filter>label {
    margin-right: 20px;
  }

  .pull-right {
    display: inline-flex;
  }

  .badgePrimary {
    color: #007bff;
    /* background-color: #007bff; */
  }

  .badgeSecondary {
    color: #6c757d;
    /* background-color: #6c757d; */
  }

  .badgeInfo {
    color: #17a2b8;
    /* background-color: #17a2b8; */
  }

  .badgeWarning {
    color: #ac871b;
    /* background-color: #ffc107; */
  }

  img {
    vertical-align: middle;
    border-style: none;
    width: 100px;
    height: 100px;
  }

  div#addVehicle div {
    margin-top: 20px !important;
  }

  form#form {
    display: flex;
  }

  select#vehiclecategory {
    width: 25%;
    margin-left: 14px;
    margin-right: 14px;
  }

  i.far.fa-trash-alt {
    margin-left: 10px;
  }
</style>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    @include('layouts.admin.navbar')

    @include('layouts.admin.sidebar')

    @yield('content')

    <footer class="main-footer">
      <!-- <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.0.5
    </div> -->
      <strong>Copyright &copy; 2021-2022 <a href="javascript:">Smatserv</a>.</strong> All rights
      reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="{{ asset('public/plugins/jquery/jquery.min.js') }}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js" integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw==" crossorigin="anonymous"></script>
  <!-- DataTables -->
  <script src="{{ asset('public/plugins/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('public/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
  <!-- <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script> -->
  <!-- <script src="{{ asset('public/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('public/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>  -->


  <!-- AdminLTE App -->
  <script src="{{ asset('public/dist/js/adminlte.min.js') }}"></script>
  <script src="{{ asset('public/dist/js/summernote-bs4.min.js') }}"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{ asset('public/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
  <script src="{{ asset('public/dist/js/demo.js') }}"></script>
  <script src="{{ asset('public/dist/js/custom.js') }}"></script>
  <!-- page script -->
  <script>
    $(document).ready(function() {
      bsCustomFileInput.init();
    });

    function deleteList($id) {
      var uri = '/admin/vehicle-delete';
      var token = $('meta[name="csrf-token"]').attr('content');
      $.ajax({
        type: "POST",
        url: uri,
        data: {
          'id': $id,
          "_token": token
        },
        dataType: "json",
        success: function(result) {
          console.log(result.code);
          if (result.code == 200) {
            location.reload();
          }
        },
        error: function(error) {
          //var obj = $.parseJSON(error.responseText);
          console.log(error);
        }
      });
    }

    function EditList($id) {
      var uri = '/admin/vehicle-edit';
      var token = $('meta[name="csrf-token"]').attr('content');
      $.ajax({
        type: "POST",
        url: uri,
        data: {
          'id': $id,
          "_token": token
        },
        dataType: "json",
        success: function(result) {
          console.log(result.code);
          if (result.code == 200) {
            location.reload();
          }
        },
        error: function(error) {
          //var obj = $.parseJSON(error.responseText);
          console.log(error);
        }
      });
    }
    $(function() {
      $("#example1").DataTable({
        "responsive": true,
        "autoWidth": false,
        "scrollX": true
      });
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
      $("#example3").DataTable({
        "responsive": true,
        "autoWidth": false,
        "scrollX": true
      });

      $("#example4").DataTable({
        "responsive": true,
        "autoWidth": false,
        "scrollX": true
      });

      $('#summernote').summernote();
    });

    $(document).ready(function() {

      $('<div class="pull-right">' +
        '<select class="form-control" id="category">' +
        '<option value="">Select</option>' +
        '<option value="Mechanics">Mechanics</option>' +
        '<option value="Towing">Towing</option>' +
        '<option value="Courier">Courier</option>' +
        '<option value="Haulage Truck">Haulage Truck</option>' +
        '</select>' +
        '</div>').appendTo("#example1_wrapper .dataTables_filter"); //example is our table id



      $('<div class="pull-right">' +
        '<select class="form-control" id="category3">' +
        '<option value="">Select</option>' +
        '<option value="Mechanics">Mechanics</option>' +
        '<option value="Towing">Towing</option>' +
        '<option value="Courier">Courier</option>' +
        '<option value="Haulage Truck">Haulage Truck</option>' +
        '</select>' +
        '</div>').appendTo("#example3_wrapper .dataTables_filter");


      var table = $('#example1').DataTable();
      $('#category').on('change', function() {
        // column as index of table
        table.columns(7).search(this.value).draw();
        console.log(table.columns(7).search(this.value).draw());
      });

      var table = $('#example3').DataTable();
      $('#category3').on('change', function() {
        // column as index of table
        table.columns(8).search(this.value).draw();
      });

      $("#addDiv").click(function() {
        var html = '';
        html += '<div class="col-5"><input type="text" class="form-control" name="vehicle[]" placeholder="vehicle" required="required"></div><div class="col-5"><input type="text" class="form-control" name="price[]" placeholder="price" required="required"></div>';
        $('#addVehicle').prepend(html);
      });


      setTimeout(function() {
        $('#flash_message_alert').fadeOut('fast');
      }, 6000); // <-- time in milliseconds



    });
  </script>
</body>
</html>