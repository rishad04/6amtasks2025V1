@extends('frontend.partials.master')

@section('container')
    <!-- Page Title -->
    <div class="page-title light-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Contact</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="index.html">Home</a></li>
                    <li class="current">Contact</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <!-- Contact Section -->
    <section id="contact" class="contact section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <h1> Login </h1>
            <div class="row gy-4">

                <div class="col-lg-8">
                    <form action="{{ route('frontend.login.submit') }}" method="POST" class="php-email-form" data-aos="fade-up"
                        data-aos-delay="200">
                        @csrf <!-- CSRF token for security -->

                        <div class="row gy-4">
                            <div class="col-md-12">
                                <input type="email" class="form-control" name="email" placeholder="Your Email" required="">
                            </div>
                            <div class="col-md-12">
                                <input type="password" class="form-control" name="password" placeholder="Your Password" required="">
                            </div>

                            <div class="col-md-12 text-center">
                                <div class="loading">Loading</div>
                                <div class="error-message"></div>
                                <div class="sent-message">Your message has been sent. Thank you!</div>

                                <button type="submit">Login</button>
                                <button>
                                    <a href="{{ route('frontend.register') }}">Not a user? Register now</a>
                                </button>
                            </div>
                        </div>
                    </form>
                </div><!-- End Contact Form -->

            </div>

        </div>

    </section><!-- /Contact Section -->
@endsection
