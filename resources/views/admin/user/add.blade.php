@extends('layouts.admin.layout')
@section('content')

<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-12">
                <div class="card card-warning">
                    <div class="card-header">
                        <h2 class="card-title">Add User</h2>
                    </div>
                    <form action="{{ route('users.store') }}" method="POST" id="form" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-6 form-group">
                                    <label for="">First Name</label>
                                <input type="text" name="first_name"  class="form-control">
                                </div>

                                <div class="col-12 col-md-6 form-group">
                                    <label for="">Last Name</label>
                                <input type="text" name="last_name"  class="form-control">
                                </div>
                                
                                <div class="col-12 col-md-6 form-group">
                                    <label for="">Email</label>
                                    <input type="email" name="email" class="form-control">
                                </div>

                                <div class="col-12 col-md-6 form-group">
                                    <label for="">Company</label>
                                    <input type="text" name="company" class="form-control">
                                </div>

                                <div class="col-12 col-md-6 form-group">
                                    <label for="">Type</label>
                                    <select class="form-control select w-100" id="select"
                                                                name="type">
                                                                <option value="1">Super User</option>
                                                                <option value="2">User</option>
                                                            </select>
                                </div>

                                <div class="col-12 col-md-6 form-group">
                                    <label for="">Password</label>
                                    <input type="password" name="password" class="form-control">
                                </div>

                                <div class="col-12 col-md-6 form-group">
                                    <label for="">Deal Id</label>
                                    <select class="form-control select w-100" id="select"
                                                                name="deal[]" multiple="multiple">
                                                                @foreach ($report as $item)
                                                                    <option value="{{ $item->deal_id }}  ">
                                                                        {{ $item->deal_id }} </option>
                                                                @endforeach
                                                            </select>
                                </div>
                                
                            </div>
                        </div>
                        <div class="card-footer">
                            <input type="submit" value="Submit" class="btn btn-success d-block mx-auto">

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