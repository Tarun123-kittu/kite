<header id="header" class="header">
    <div class="top-left">
        <div class="navbar-header">
            <a class="navbar-brand" href="./"><img src="{{ asset("images/mariano.png") }}" alt="Logo"></a>
            <a class="navbar-brand hidden" href="./"><img src="{{ asset("images/logo2.png") }}" alt="Logo"></a>
            <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
        </div>
    </div>
    <div class="top-right">
        <div class="header-menu">
            <div class="user-area dropdown float-right">
                <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="user-avatar rounded-circle" src="{{ asset("images/admin.jpg") }}" alt="User Avatar">
                </a>

                <div class="user-menu dropdown-menu">
                    <a class="nav-link" href="{{route('show.profile')}}"><i class="fa fa- user"></i>My Profile</a>
                    <a class="nav-link" href="{{route('admin.changepassword')}}"><i class="fa fa- user"></i>Change Password</a>
                    <a class="nav-link" href="{{route('admin.logout')}}"><i class="fa fa-power -off"></i>Logout</a>
                </div>
            </div>

        </div>
    </div>
</header>