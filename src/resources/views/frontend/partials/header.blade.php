<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

        <a href="index.html" class="logo d-flex align-items-center me-auto">
            <!-- Uncomment the line below if you also wish to use an image logo -->
            <!-- <img src="assets/img/logo.png" alt=""> -->
            <h1 class="sitename">Rishad Hossain's Task Submission Frontend</h1>

        </a>

        <nav id="navmenu" class="navmenu" style="margin-right:10px">
            <ul>
                <li><a href="{{ route('frontend.landing.index') }}" class="active">Home</a></li>
                {{-- <li><a href="{{ route('frontend.landing.index2') }}" class="active">Home2 Auth</a></li> --}}

                {{-- <li><a href="auth.html">Login</a></li>
                <li><a href="auth.html">Register</a></li> --}}
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
        @if (auth()->user() != '')
            <h6 class="sitename">Logged In As {{ auth()->user()->name }} | </h6>

            <h6 class="sitename"> Cash Amount: {{ auth()->user()->have_cash_amount }} Tk</h6>

            {{-- <a class="btn-getstarted" href="{{ route('frontend.logout') }}"> Logout</a> --}}

            <form action="{{ route('frontend.logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit">Logout</button>
            </form>
        @else
            <a class="btn-getstarted" href="{{ route('frontend.login') }}">Login/Register</a>
        @endif

    </div>
</header>
