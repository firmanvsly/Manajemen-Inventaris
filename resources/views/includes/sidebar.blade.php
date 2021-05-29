<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">

        <div class="navbar-header">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu"
                aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <h6>Inventaris</h6>
            </a>
            <a class="navbar-brand hidden" href="{{ route('dashboard') }}">
                <h6>I</h6>
            </a>
        </div>

        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="{{ Request::segment(1) == 'dashboard' ? 'active' : 'asu' }}">
                    <a href="{{ route('dashboard') }}"> <i class="menu-icon fa fa-dashboard"></i>Dashboard </a>
                </li>
                @if (Auth::user()->hasRole('Owner') || (Auth::user()->hasRole('Manager') && Auth::user()->hasPermission('user','read')))
                    <li class="{{ Request::segment(1) == 'user' ? 'active' : '' }}">
                        <a href="{{ route('user.index') }}"> <i class="menu-icon fa fa-users"></i>User </a>
                    </li>
                    @if (Auth::user()->hasRole('Owner'))
                        <li class="{{ Request::segment(1) == 'role' ? 'active' : '' }}">
                            <a href="{{ route('role.index') }}"> <i class="menu-icon fa fa-lock"></i>Role </a>
                        </li>
                    @endif
                @endif
                @if (Auth::user()->hasRole('Owner') || (Auth::user()->hasRole('Manager') && Auth::user()->hasPermission('barang','read')))
                    <li class="{{ Request::segment(1) == 'barang' ? 'active' : '' }}">
                        <a href="{{ route('barang.index') }}"> <i class="menu-icon fa fa-dropbox"></i>Barang </a>
                    </li>
                @endif
                @if (Auth::user()->hasRole('Owner') || (Auth::user()->hasRole('Manager') && Auth::user()->hasPermission('ruangan','read')))
                    <li class="{{ Request::segment(1) == 'ruangan' ? 'active' : '' }}">
                        <a href="{{ route('ruangan.index') }}"> <i class="menu-icon fa fa-building-o"></i>Ruangan </a>
                    </li>
                @endif
                @if (Auth::user()->hasRole('Owner') || Auth::user()->hasRole('Manager'))
                    <li class="{{ Request::segment(1) == 'kategori' ? 'active' : '' }}">
                        <a href="{{ route('kategori.index') }}"> <i class="menu-icon fa fa-th"></i>Kategori </a>
                    </li>
                    @if (Auth::user()->hasRole('Manager'))
                        <li class="{{ Request::segment(1) == 'laporan' ? 'active' : '' }}">
                            <a href="{{ route('laporan.index') }}"> <i class="menu-icon fa fa-book"></i>Laporan </a>
                        </li>
                    @endif
                @endif
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside>
