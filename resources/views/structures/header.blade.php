<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a class="navbar-brand" href="{{ url('/home') }}">
            <img src="{{ asset('assets/img/walstarLogo.png') }}" alt="Walstar Logo"
                class="img-fluid d-inline-block align-top" style="height: 40px;">
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>

    <div class="search-bar">
        <form class="search-form d-flex align-items-center" method="" action="#">
            <input type="text" name="query" placeholder="Search" title="Enter search keyword">
            <button type="submit" title="Search"><i class="bi bi-search"></i></button>
        </form>
    </div>

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <li>
                @if (Auth::check())
                    <h4 class="mb-0">Welcome {{ Auth::user()->name }}</h4>
                    <!-- Optional: added mb-0 to remove default margin -->
                @endif
            </li>

            <li class="nav-item dropdown pe-3 ms-3"> <!-- Added ms-3 to create left margin -->
                @if (Auth::check())
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="btn btn-danger d-flex align-items-center">
                        <i class="bi bi-box-arrow-right me-1"></i> <!-- Logout icon -->
                        Logout
                    </a>
                @endif
            </li>
        </ul>
    </nav>

</header>
