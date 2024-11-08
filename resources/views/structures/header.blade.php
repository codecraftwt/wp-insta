<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="home" class="logo d-flex align-items-center">
            <img src="assets/img/walstarLogo.png" alt="">
            <span class="d-none d-lg-block"></span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->


    {{-- <div class="search-bar">
        <form class="search-form d-flex align-items-center" method="" action="#">
            <input type="text" name="query" placeholder="Search" title="Enter search keyword">
            <button type="submit" title="Search"><i class="bi bi-search"></i></button>
        </form>
    </div> --}}

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <li>
                @if (Auth::check())
                    <span class="mb-0">Hello {{ Auth::user()->name }}</span>

                    <!-- Optional: added mb-0 to remove default margin -->
                @endif
            </li>

            <li class="nav-item dropdown pe-3 ms-3"> <!-- Added ms-3 to create left margin -->
                @if (Auth::check())
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="btn btn-primary d-flex align-items-center">
                        <i class="bi bi-box-arrow-right "></i> <!-- Logout icon -->

                    </a>
                @endif
            </li>
        </ul>


    </nav>

</header>
