@extends('layouts.admin.layout')
@section('content')
<div class="container mt-5">
    <div class="d-flex py-2 align-items-center">
        <h2 class=" flex-grow-1  ">User List</h2>
       <div>
        <a href="{{ route('users.add') }}" class="btn btn-primary  ">Add User</a>
       </div>
    </div>
    
    <table class="table table-bordered yajra-datatable">
        <thead>
            <tr>
                <th>No</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Company</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

@endsection
@section('footer-script')
<script type="text/javascript">
    $(function () {
      
      var table = $('.yajra-datatable').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('users.list') }}",
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex'},
              {data: 'first_name', name: 'first_name'},
              {data: 'last_name', name: 'last_name'},
              {data: 'email', name: 'email'},
              {data: 'company', name: 'company'},
             
              {
                  data: 'action', 
                  name: 'action', 
                  orderable: true, 
                  searchable: true
              },
          ]
      });
      
    });
  </script>
@endsection