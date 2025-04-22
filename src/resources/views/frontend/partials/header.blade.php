<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

        <a href="index.html" class="logo d-flex align-items-center me-auto">
            <!-- Uncomment the line below if you also wish to use an image logo -->
            <!-- <img src="assets/img/logo.png" alt=""> -->
            <h1 class="sitename">6amTask By Rishad: Frontend</h1>

        </a>

        {{-- <button onclick="showNotification('Welcome! This is a test notification.')">Show Notification</button> --}}

        @if (auth()->user() != '')
            <button class="btn btn-success" onclick="showNotification('You have a new message!')">Notifications
            </button>

            <div class="notification" id="notification">
                <div class="message" id="notifications"></div>
                <button class="close-btn" onclick="hideNotification()">&times;</button>
            </div>
        @endif

        <nav id="navmenu" class="navmenu" style="margin-right:10px">
            {{-- @dd(request()->url()) --}}
            <ul>

                <li>
                    <a href="{{ route('frontend.landing.index') }}" class="{{ request()->is('home*') ? 'active' : '' }}">Home</a>
                </li>
                <li>
                    <a href="{{ route('frontend.product-showcase.index') }}"
                        class="{{ request()->is('product-showcase') ? 'active' : '' }}">Products</a>
                </li>

                @php
                    try {
                        // Using Redis::connection() to ping the Redis server
                        $isRedisRunning = \Illuminate\Support\Facades\Redis::ping() === 'PONG';
                        $isRedisRunning = true;
                    } catch (\Exception $e) {
                        // In case Redis is not available
                        $isRedisRunning = false;
                    }
                @endphp

                @if ($isRedisRunning)
                    <li>
                        <a href="{{ route('frontend.product-showcase-cached.index') }}"
                            class="{{ request()->is('product-showcase-cached*') ? 'active' : '' }}">
                            Products(Cached)
                        </a>
                    </li>
                @endif
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
        @if (auth()->user() != '')
            {{-- <h6 class="sitename">Logged In As {{ auth()->user()->name }} | </h6>

            <h6 class="sitename"> Cash Amount: {{ auth()->user()->have_cash_amount }} Tk</h6> --}}

            {{-- <a class="btn-getstarted" href="{{ route('frontend.logout') }}"> Logout</a> --}}

            <form action="{{ route('frontend.logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        @else
            <a class="btn btn-success mr-5" href="{{ route('frontend.login') }}">Login</a>
            <a class="btn btn-danger" href="{{ route('frontend.register') }}">Register</a>
        @endif

    </div>
</header>
