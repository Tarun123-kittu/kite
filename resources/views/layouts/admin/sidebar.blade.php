<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="{{request()->routeIs('dashboard')?'active':''}}">
                    <a href="{{route('dashboard')}}"><i class="menu-icon fa fa-laptop"></i>Home </a>
                </li>
                <?php if(Session::get('admin')->type == 1) { ?>
                <li class="{{request()->routeIs('users')?'active':''}}">
                    <a href="{{route('users')}}"><i class="menu-icon fa fa-user"></i>Users </a>
                </li>
                <?php } ?>
                <li class="{{request()->routeIs('reports')?'active':''}}">
                    <a href="{{route('reports')}}"><i class="menu-icon fa fa-file-text-o"></i>Reports </a>
                </li>
               


            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside>