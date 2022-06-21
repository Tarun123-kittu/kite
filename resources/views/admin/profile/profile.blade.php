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
                        <h2 class="card-title">Profile</h2>
                    </div>
                    <form action="{{ route('profile') }}" method="POST" id="form" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-6 form-group">
                                    <label for="">First Name</label>
                                <input type="text" name="first_name" value="{{$AdminUser->first_name}}" class="form-control">
                                </div>

                                <div class="col-12 col-md-6 form-group">
                                    <label for="">Last Name</label>
                                <input type="text" name="last_name" value="{{$AdminUser->last_name}}" class="form-control">
                                </div>
                                
                                <div class="col-12 col-md-6 form-group">
                                    <label for="">Email</label>
                                    <input type="email" name="email" value="{{$AdminUser->email}}" class="form-control">
                                </div>

                                <div class="col-12 col-md-6 form-group">
                                    <label for="">Company</label>
                                    <input type="text" name="company" value="{{$AdminUser->company}}" class="form-control">
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

