<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">

        <div class="navbar-header">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="{{ route('dashboard') }}"><h6>Inventaris</h6></a>
            <a class="navbar-brand hidden" href="{{ route('dashboard') }}"><h6>I</h6></a>
        </div>

        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active">
                    <a href="{{ route('dashboard') }}"> <i class="menu-icon fa fa-dashboard"></i>Dashboard </a>
                </li>
                <li>
                    <a href="index.html"> <i class="menu-icon fa fa-users"></i>Users </a>
                </li>
                <li>
                    <a href="index.html"> <i class="menu-icon fa fa-dropbox"></i>Barang </a>
                </li>
                <li>
                    <a href="index.html"> <i class="menu-icon fa fa-building-o"></i>Ruangan </a>
                </li>
                <li>
                    <a href="index.html"> <i class="menu-icon fa fa-th"></i>Kategori </a>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside>