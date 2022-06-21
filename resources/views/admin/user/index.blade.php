@extends('layouts.admin.layout')
@section('content')
<div class="content">
 <div class="card">
  <div class="card-body pb-0">
    <div class="d-flex py-2 align-items-center">
        <h5 class=" flex-grow-1  ">User List</h5>
       <div>
        <a href="{{ route('users.add') }}" class="btn btn-primary cm-btns  ">Add User</a>
       </div>
    </div>
  </div>
    
   <div class="card-body data_tabel">
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
 </div>
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