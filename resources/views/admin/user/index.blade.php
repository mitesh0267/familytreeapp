@extends('admin.layouts.master')

@section('title','User')

@section('content')

<div class="content-header row">
  <div class="content-header-left col-md-9 col-12 mb-2">
    <div class="row breadcrumbs-top">
      <div class="col-12">
        <h2>User</h2>
      </div>
    </div>
  </div>
</div>
        
<div class="content-body"><!-- Validation -->
  <section class="bs-validation">
    <div class="row">
      <div class="col-md-12 col-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Users List</h4>
          </div>
          <div class="card-body">
            
            <table class="datatables-basic table display nowrap" id="myTable" style="width:100%">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                 
              </tbody>
              <tfoot>
                  <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
              </tfoot>
            </table>

          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection


@push('css')

@endpush

@push('script')
  <script src="{{asset('assets/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('assets/app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js')}}"></script>
  <script src="{{asset('assets/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js')}}"></script>
  <script src="{{asset('assets/app-assets/vendors/js/tables/datatable/responsive.bootstrap5.min.js')}}"></script>
  <script src="{{asset('assets/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js')}}"></script>

  <script src="{{ asset('assets/app-assets/vendors/js/') }}/sweetalert2/sweetalert2.all.min.js"></script>

  <script type="text/javascript">

    $(document).ready(function() {
      
      render_table();

      function render_table(){
        var table = $("#myTable");
        table.DataTable().destroy();
        console.log("yes");

        table.DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            ajax: {
                'url': "{{ route('user.get-all') }}",
                'type': 'POST',
                headers: {
                  'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                // data:{
                // }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'status', name: 'status', orderable: false, searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            drawCallback:function(){
                $(function () {
                  $('[data-toggle="tooltip"]').tooltip()
                  $('table tbody tr td:last-child').attr('nowrap', 'nowrap');
                })
            },
            initComplete: function () {
            }
          });
      }

      $(document).on('click', '.delete', function(event) {
          event.preventDefault();
          $url = $(this).attr('data-url');

          Swal.fire({
            title: 'Are you sure?',
            text: "Once deleted, you will not be able to recover this record!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                url: $url,
                method: "DELETE",
                data: {
                        _token:'{{ csrf_token() }}' 
                      }
              })
              .done(function(result) {
                if(result.status == false){
                  toast_error(result.message);
                }else{
                  toast_success(result.message);
                  render_table();
                }
              })
              .fail(function() {
                toast_error("error");
              });


            }
          })
      });

      $(document).on('click', '.status', function(event) {
          event.preventDefault();
          $url = $(this).attr('data-url');

          Swal.fire({
            title: 'Are you sure want to change status?',
            //text: "Once deleted, you will not be able to recover this record!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, change it!'
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                url: $url,
              })
              .done(function(result) {
                if(result.status == false){
                  toast_error(result.message);
                }else{
                  toast_success(result.message);
                  render_table();
                }
              })
              .fail(function() {
                toast_error("error");
              });
            }
          })
      });

      $(document).on('click', '.edit_to_access', function(event) {
          event.preventDefault();
          $url = $(this).attr('data-url');

          Swal.fire({
            title: 'Are you sure want to change edit access?',
            //text: "Once deleted, you will not be able to recover this record!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, change it!'
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                url: $url,
              })
              .done(function(result) {
                if(result.status == false){
                  toast_error(result.message);
                }else{
                  toast_success(result.message);
                  render_table();
                }
              })
              .fail(function() {
                toast_error("error");
              });
            }
          })
      });
    });
  </script>
@endpush
