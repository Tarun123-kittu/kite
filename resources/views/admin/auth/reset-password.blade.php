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
                    <form action='{{ route('reset-password',[$email,$hash]) }}' method="POST" id='form'>
                        @csrf
                        <span class="login100-form-title p-b-53">
                            Reset Password
                        </span>
                        <br><br>
                        <input type="hidden" name="hash" value="{{ $passwordLink->password_token }}">
                        <input type="hidden" name="email" value="{{ $passwordLink->email }}">
                        <div class="form-group">
                            <input class="form-control" type="password" name="password" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="password" name="password_confirmation" placeholder="Confirm Password" required>
                        </div>

                        <button type="submit" class="btn mt-5">Change Password</button>
                        

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    @endsection
    
    @section('footer-section')
    $(function () {
        $("#form").submit(function () {
            Noty.closeAll();
            $("input[type='submit']").prop('disabled',true);
            var n = new Noty({text:"Please Wait"}).show();
            $.ajax({
                type: "POST",
                url: $(this).attr("action"),
                data: $(this).serialize(),
                success: function (response) {
                    n.setType(response.notification.status);
                    n.setText(response.notification.message);
                    n.setTimeout(3000);
                    if(response.notification.status=='success'){
                        setTimeout(function(){
                            window.location='{{ route('dashboard') }}';
                        },3000);
                    }
                },
                error:function(response){
                    n.setType(response.responseJSON.notification.status);
                    n.setText(response.responseJSON.notification.message);
                    n.setTimeout(3000);
                }
            });
            $("input[type='submit']").prop('disabled',false);
            return false;
        });
    });
    @endsection