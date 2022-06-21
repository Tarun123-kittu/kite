@extends('layouts.auth.layout')
@section('content')
<div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <div class="log_in_form">
                    <div class="login-logo">
                        <a href="index.html">
                            <img class="align-content" src="{{ asset('images/mariano.png') }}" alt="">
                        </a>
                    </div>
                    <div class="login-form">

                        <form  action="{{route('forgot-password')}}" id='form' method="POST">
                            @csrf
                            <span class="login100-form-title p-b-53">
                                Forgot Password?
                            </span>
                            <br><br>
                            <div class="form-group" data-validate="Username is required">
                                <input class="input100" type="email" name="email" placeholder="Enter Email">
                                <span class="focus-input100"></span>
                            </div>
                            
                                <button type="submit" class="btn mt-2">
                                    Reset Password
                                </button>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
    @endsection
