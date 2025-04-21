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
    {{-- @dd(auth()->user()) --}}

    <!-- Contact Section -->
    <section id="contact" class="contact section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <h1> Register </h1>

            <div class="row gy-4">

                <div class="col-lg-8">
                    <form action="{{ route('frontend.register.submit') }}" method="POST" class="php-email-form" data-aos="fade-up"
                        data-aos-delay="200">
                        @csrf
                        <div class="row gy-4">

                            <!-- Name Field -->
                            <div class="col-md-12">
                                <input type="text" name="name" class="form-control" placeholder="Your Name" required
                                    value="{{ old('name') }}">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email Field -->
                            <div class="col-md-12">
                                <input type="email" class="form-control" name="email" placeholder="Your Email" required
                                    value="{{ old('email') }}">
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password Field -->
                            <div class="col-md-12">
                                <input type="password" class="form-control" name="password" placeholder="Your Password" required>
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password Confirmation Field -->
                            <div class="col-md-12">
                                <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Your Password"
                                    required>
                                @error('password_confirmation')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Register Button -->
                            <div class="col-md-12 text-center">
                                <div class="loading">Loading...</div>
                                <div class="error-message"></div>

                                <button type="submit">Register</button>
                                <button><a href="{{ route('frontend.login') }}">Login</a></button>
                            </div>

                        </div>
                    </form>
                </div><!-- End Contact Form -->

            </div>

        </div>

    </section><!-- /Contact Section -->
@endsection
