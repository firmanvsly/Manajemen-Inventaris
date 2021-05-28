<header id="header" class="header">
    
    <div class="header-menu">

        <div class="col-sm-7">
            <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a>
        </div>

        <div class="col-sm-5">
            <div class="user-area dropdown float-right">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="user-avatar rounded-circle" src="{{ asset('assets/images/admin.jpg') }}" alt="User Avatar">
                </a>

                <div class="user-menu dropdown-menu">

                    <form id="logout" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <a class="nav-link" href="#" onclick="document.getElementById('logout').submit();"><i class="fa fa-power-off"></i> Logout</a>
                    </form>
                </div>
            </div>

        </div>
    </div>

</header>