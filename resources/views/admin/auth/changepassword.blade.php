@extends('layouts.admin.layout')
@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-12">
                <div class="card card-warning">
                    <div class="card-header">
                        <h2 class="card-title">Change Password</h2>
                    </div>
                    <form action="{{ route('admin.changepassword') }}" method="POST" id="form">
                        <div class="card-body">
                            <div class="row">
                                @csrf
                                <div class="col-12 col-sm-8 col-md-4 offset-sm-2 offset-md-4 form-group">
                                    <label for="">Current Password</label>
                                    <input type="password" name="password" class="form-control">
                                </div>
                                <div class="col-12 col-sm-8 col-md-4 offset-sm-2 offset-md-4 form-group">
                                    <label for="">New Password</label>
                                    <input type="password" name="new_password" class="form-control">
                                </div>
                                <div class="col-12 col-sm-8 col-md-4 offset-sm-2 offset-md-4 form-group">
                                    <label for="">Confirm New Password</label>
                                    <input type="password" name="new_password_confirmation" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <input type="submit" value="Update" class="btn btn-success d-block mx-auto">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->
</section>
@endsection

