@extends('frontend.partials.master')

@section('container')
    <!-- Hero Section -->

    <section id="hero" class="hero section dark-background">
        @if (auth()->user() != '')
            {{-- <h6 class="sitename">Logged In As {{ auth()->user()->name }} | </h6>

    <h6 class="sitename"> Cash Amount: {{ auth()->user()->have_cash_amount }} Tk</h6> --}}

            <h2>Welcome, {{ auth()->user()->name }} !</h2>
            {{-- <p>Hello, From here you can choose subscription plans</p> --}}
        @else
            <h2>Welcome To Landing Page</h2>
            <p>Hello, From here you can choose subscription plans, and also do login/register</p>
        @endif
    </section>
    <!-- pricing Section -->
    <section id="pricing" class="pricing section">

        {{-- <div id="notifications"></div> --}}

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Task 1: Subscription Management</h2>
            <p>Subscription Plans<br></p>
        </div><!-- End Section Title -->

        <div class="container ">

            <div class="row gy-4 plan-cart">

                @foreach ($plans_frontend as $plan)
                    <div class="col-xl-4 col-lg-6 " data-aos="fade-up" data-aos-delay="100">
                        <div class="pricing-item {{ $plan->slug == 'basic' ? 'featured' : '' }}">
                            <h3>{{ $plan->title }}</h3>
                            <h4><sup>Tk</sup>{{ $plan->price }}<span> / {{ $plan->billing_cycle }}</span></h4>
                            <ul>
                                <li>{{ $plan->title }} Plan</li>
                                <li>Billing Cycle: {{ $plan->billing_cycle->label() }}</li>
                                {{-- <li class="na">Massa ultricies mi</li> --}}
                            </ul>
                            <div class="btn-wrap">
                                @auth
                                    <!-- If the user is authenticated, show the subscribe button -->

                                    @php
                                        $subscription = auth()->user()->activeSubscription();
                                        // dd($subscription);
                                    @endphp

                                    @if ($subscription != null && $subscription->subscriptionPlan->id == $plan->id)
                                        <a href="javascript:void(0);" class="btn-buy-green subscriptionView " id="subscribeButton2"
                                            data-plan-id="{{ $plan->id }}" data-plan-user-id="{{ $subscription->id }}">
                                            {{ $subscription->subscriptionPlan->id == $plan->id ? 'View Subscription' : 'Subscribe Now' }}
                                        </a>

                                        <a href="javascript:void(0);" class="btn-buy-cancel cancelSubscriptionBtn"
                                            data-subscription-id="{{ $subscription->id }}">
                                            <i class="fas fa-times-circle"></i> Cancel
                                        </a>
                                    @else
                                        <a href="javascript:void(0);" class="btn-buy subscribeButton" id="subscribeButton"
                                            data-plan-id="{{ $plan->id }}">
                                            Subscribe Now
                                        </a>
                                    @endif

                                    {{-- <a href="javascript:void(0);" class="btn-buy subscribeButton" id="subscribeButton"
                                        data-plan-id="{{ $plan->id }}">Subscribe
                                        Now</a> --}}

                                @endauth

                                @guest
                                    <!-- If the user is not authenticated, redirect to the login page -->
                                    <a href="{{ route('frontend.login') }}" class="btn-buy">Login To Subscribe</a>
                                @endguest
                            </div>
                        </div>
                    </div><!-- End Pricing Item -->
                @endforeach

            </div>

        </div>

    </section><!-- /About Section -->
    <!-- Pricing Section -->
    <!-- Your pricing content here (unchanged logic-wise) -->

    <!-- Clients Section -->
    <section id="clients" class="clients section light-background">
        <div class="container" data-aos="fade-up">
            <div class="row gy-4">
                @for ($i = 1; $i <= 6; $i++)
                    <div class="col-xl-2 col-md-3 col-6 client-logo">
                        <img src="{{ asset("frontend/assets/img/clients/client-$i.png") }}" class="img-fluid"
                            alt="Client {{ $i }}">
                    </div>
                @endfor
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <!-- Your services content here (unchanged logic-wise) -->

    <!-- Portfolio Section -->
    <section id="portfolio" class="portfolio section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Portfolio</h2>
            <p>Necessitatibus eius consequatur</p>
        </div>

        <div class="container">
            <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">
                <ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
                    <li data-filter="*" class="filter-active">All</li>
                    <li data-filter=".filter-app">App</li>
                    <li data-filter=".filter-product">Card</li>
                    <li data-filter=".filter-branding">Web</li>
                </ul>

                <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">
                    @for ($i = 1; $i <= 9; $i++)
                        @php
                            $filter = match (true) {
                                $i % 3 === 1 => 'filter-app',
                                $i % 3 === 2 => 'filter-product',
                                default => 'filter-branding',
                            };
                        @endphp
                        <div class="col-lg-4 col-md-6 portfolio-item isotope-item {{ $filter }}">
                            <img src="{{ asset("frontend/assets/img/masonry-portfolio/masonry-portfolio-$i.jpg") }}" class="img-fluid"
                                alt="Portfolio {{ $i }}">
                            <div class="portfolio-info">
                                <h4>Item {{ $i }}</h4>
                                <p>Lorem ipsum, dolor sit</p>
                                <a href="{{ asset("frontend/assets/img/masonry-portfolio/masonry-portfolio-$i.jpg") }}"
                                    title="Item {{ $i }}" data-gallery="portfolio-gallery" class="glightbox preview-link"><i
                                        class="bi bi-zoom-in"></i></a>
                                <a href="portfolio-details.html" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Structure -->
    <div id="subscriptionModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="subscriptionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="subscriptionModalLabel">Subscription Details</h5>
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> --}}
                </div>
                <div class="modal-body">
                    <!-- Subscription details will be populated here -->
                    <div id="subscriptionDetails">
                        <!-- Dynamic content will go here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary modal-close" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('frontend_scripts')
    <script>
        $(document).ready(function() {
            // When the Subscribe Now button is clicked
            $('.subscribeButton').click(function(e) {
                console.log('clicked');
                e.preventDefault(); // Prevent default link behavior

                // Get the plan ID from the data attribute
                const planId = $(this).data('plan-id');

                // Send the AJAX POST request
                $.ajax({
                    url: '{{ route('subscribe') }}', // The route to the subscribe method
                    method: 'POST',
                    data: {
                        plan_id: planId, // Send the plan ID to the server
                        _token: '{{ csrf_token() }}' // CSRF token for security
                    },
                    success: function(response) {

                        // console.log(response);
                        // Handle the success response
                        if (response.result === true) {
                            SwalFlashMiddlelert('Subscribed', 'Subscribed successfully!', 'Thanks for subscribing');
                            // console.log(location.href);
                            location.reload();
                        } else {
                            SwalFlashMiddlelert('Failed', 'Payment Failed!', 'Please Try Again', 'error');
                        }
                    },
                    error: function(xhr, status, error) {

                        console.log('xhr:', xhr);
                        console.log('status:', status);
                        console.log('error:', error);
                        // Handle the error response
                        if (xhr.status === 409) {
                            SwalFlashMiddlelert('Warning', 'Already Have This Subscription!',
                                'Please Try Another One', 'warning');
                        } else if (xhr.status === 403) {
                            SwalFlashMiddlelert('Not Allowed', 'Downgrade not allowed!',
                                'Please choose a higher level plan', 'warning');
                        } else {
                            SwalFlashMiddlelert('Failed', 'An error occurred.', 'Please try again later.', 'error');
                        }
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {

            $('.modal-close').on('click', function() {
                $('#subscriptionModal').modal('hide');
            });

            // When "View Subscription" button is clicked
            $('.subscriptionView').on('click', function() {
                var planId = $(this).data('plan-user-id'); // Get the plan ID from the button

                console.log(planId);
                // Make an AJAX request to fetch the subscription data
                $.ajax({
                    url: '/subscription-view/' + planId,
                    method: 'GET',
                    data: {
                        _token: '{{ csrf_token() }}', // CSRF token for security
                    },
                    success: function(response) {
                        // Check if the response is successful

                        console.log('sub-view-', response);
                        if (response.result && response.status_code == 200) {
                            var subscriptionData = response.data;

                            var modalContent = `
                                <p><strong>User:</strong> ${subscriptionData.user?.name || 'N/A'}</p>
                                <p><strong>Plan:</strong> ${subscriptionData.subscription_plan?.title || 'N/A'}</p>
                                <p><strong>Status:</strong> ${subscriptionData.payment_status || 'N/A'}</p>
                                <p><strong>Start Date:</strong> ${subscriptionData.start_date || 'N/A'}</p>
                                <p><strong>End Date:</strong> ${subscriptionData.end_date || 'N/A'}</p>
                            `;


                            $('#subscriptionDetails').html(modalContent);
                            $('#subscriptionModal').modal('show');
                        } else {
                            alert('Failed to load subscription details. Please try again.');
                        }
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status == 404) {
                            alert('Subscription user not found.');
                        } else {
                            alert('An error occurred. Please try again later.');
                        }
                    }
                });
            });
        });
    </script>

    <script>
        $(document).on('click', '.cancelSubscriptionBtn', function() {
            const subscriptionId = $(this).data('subscription-id');

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you really want to cancel your subscription?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Yes, cancel it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('subscription.cancel') }}", // Route name
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            subscription_id: subscriptionId
                        },
                        success: function(response) {
                            Swal.fire('Cancelled!', response.message, 'success');
                            // $('.plan-cart').load(location.href + ' .plan-cart'); // Refresh only the plan-cart
                            location.reload();
                        },
                        error: function(xhr) {
                            Swal.fire('Error!', xhr.responseJSON.message || 'Something went wrong.', 'error');
                        }
                    });
                }
            });
        });
    </script>

    {{-- task: 2 --}}

    {{-- <script>
        let lastMessage = '';

        function fetchNotification() {
            fetch('/get-latest-notification')
                .then(res => res.json())
                .then(data => {
                    if (data.message && data.message !== lastMessage) {
                        document.getElementById('notifications').innerHTML = `<p>${data.message}</p>` + document.getElementById(
                            'notifications').innerHTML;
                        lastMessage = data.message;
                    }
                });
        }

        setInterval(fetchNotification, 3000);
        fetchNotification();
    </script> --}}

    <script>
        function getCookie(name) {
            const value = `; ${document.cookie}`; // Add semicolon at the beginning to handle edge cases
            const parts = value.split(`; ${name}=`); // Split the cookie string by the name
            if (parts.length === 2) return parts.pop().split(';').shift(); // Return the cookie value if found
            return null; // Return null if cookie is not found
        }
        let login_frontend_cookie = getCookie('frontend_user_session_cookie');

        if (login_frontend_cookie != null) {
            console.log('cookie for frontend is Set');

            function checkForNotification() {
                fetch('/get-latest-notification')
                    .then(res => res.json())
                    .then(data => {
                        // console.log(data);

                        if (data.message != null) {
                            SwalFlashNotificationAlert(true, '🔔 ' + data.message, null, null);
                        }

                    })
                    .catch(error => {
                        console.error('Error fetching latest notification:', error);
                    });
            }
        } else {
            console.log('cookie for frontend is null');
        }
        // let lastMessage = '';

        // function checkForNotification() {
        //     fetch('/get-latest-notification')
        //         .then(res => res.json())
        //         .then(data => {
        //             console.log(data);

        //             // Show the SweetAlert
        //             Swal.fire({
        //                 title: data.message,
        //                 text: data.message,
        //                 icon: 'info',
        //                 showCancelButton: false, // No need for a cancel button if it's just informational
        //                 confirmButtonColor: '#d33'
        //             }).then(() => {
        //                 // After the Swal popup is closed, make another API call
        //                 fetch('/get-latest-notification-back-to-set-old')
        //                     .then(res => res.json())
        //                     .then(backToSetData => {
        //                         console.log(backToSetData);
        //                         // Handle the response after setting the notification as seen
        //                     })
        //                     .catch(error => {
        //                         console.error('Error setting notification as seen:', error);
        //                     });
        //             });
        //         })
        //         .catch(error => {
        //             console.error('Error fetching latest notification:', error);
        //         });
        // }


        // Check every 3 seconds
        setInterval(checkForNotification, 3000);

        // First check on load
        // checkForNotification();
    </script>

    {{-- <script>
        SwalFlashNotificationlert(true, ' 🔔 hellow rishad', null, null);
    </script> --}}
    {{-- <script>
        window.Echo.channel('online-users')
            .listen('.user.registered', (data) => {
                console.log("New user joined:", data);
                alert(`${data.name} just joined!`);
            });
    </script> --}}
@endpush
