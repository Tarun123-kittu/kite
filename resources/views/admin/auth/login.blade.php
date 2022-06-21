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
                        <form action='{{ route('login') }}' method="POST" id='form'>
                            @csrf
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" placeholder="Email">
                            </div>
                            <div class="form-group">

                                <input type="password" class="form-control" name="password" placeholder="Password">
                            </div>

                            <button type="submit" class="btn mt-5">Sign in</button>
                            <div class="forgot_password mt-3 text-center">
                                   <a href="{{ route('show.forgot-password') }}">Forgot password</a> 
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer-script')
    <script>
        $(function() {
            $("#form").submit(function() {
                Noty.closeAll();
                $("input[type='submit']").prop('disabled', true);
                var n = new Noty({
                    text: "Please Wait"
                }).show();
                $.ajax({
                    type: "POST",
                    url: $(this).attr("action"),
                    data: $(this).serialize(),
                    success: function(response) {
                        n.setType(response.notification.status);
                        n.setText(response.notification.message);
                        n.setTimeout(3000);
                        if (response.notification.status == 'success') {
                            setTimeout(function() {
                                window.location = '{{ route('dashboard') }}';
                            }, 3000);
                        }
                    },
                    error: function(response) {
                        console.log("heree!!!");
                        n.setType(response.responseJSON.notification.status);
                        n.setText(response.responseJSON.notification.message);
                        n.setTimeout(3000);
                    }
                });
                $("input[type='submit']").prop('disabled', false);
                return false;
            });
        });
    </script>
@endsection
