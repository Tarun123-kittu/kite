@extends('layouts.admin.layout')
@section('content')

<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-12">
                <div class="card card-warning">
                    <div class="card-header">
                        <h2 class="card-title">Update User</h2>
                    </div>
                    <form action="{{ route('user.update',$data->id) }}" method="POST" id="form" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-6 form-group">
                                    <label for="">First Name</label>
                                <input type="text" name="first_name" value="{{ $data->first_name }}"  class="form-control">
                                </div>

                                <div class="col-12 col-md-6 form-group">
                                    <label for="">Last Name</label>
                                <input type="text" name="last_name" value="{{ $data->last_name }}" class="form-control">
                                </div>
                                
                                <div class="col-12 col-md-6 form-group">
                                    <label for="">Email</label>
                                    <input type="email" name="email" value="{{ $data->email }}" class="form-control">
                                </div>

                                <div class="col-12 col-md-6 form-group">
                                    <label for="">Company</label>
                                    <input type="text" name="company" value="{{ $data->company }}" class="form-control">
                                </div>

                                <div class="col-12 col-md-6 form-group">
                                    <label for="">Type</label>
                                    <select class="form-control select w-100" id="select"
                                                                name="type">
                                                                <option  {{ $data->type == 1 ? "selected" : "" }} value="1">Super User</option>
                                                                <option {{ $data->type == 2 ? "selected" : "" }} value="2">User</option>
                                                            </select>
                                </div>
                                <?php 
                                $arr = array();
                                foreach ($data->map as $val){
                                    array_push($arr , $val->deal_id);
                                }
                               
                                ?>

                                <div class="col-12 col-md-6 form-group">
                                    <label for="">Deal Id</label>
                                    <select class="form-control select w-100" id="select"
                                                                name="deal[]" multiple="multiple">
                                                                @foreach ($report as $item)
                                                                        <option value="{{ $item->deal_id }}  " {{ in_array($item->deal_id , $arr) ? "selected" : "" }}>
                                                                        {{ $item->deal_id }} </option>
                                                                @endforeach
                                                            </select>
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
   