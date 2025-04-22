@extends('frontend.partials.master')

@section('container')
    <!-- Page Title -->
    <div class="page-title light-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <div>
                <p class="mb-2 mb-lg-0"> Backend to Frontend Page Loading Time: <span id="loading-time"></span></p>
                <p class="mb-2 mb-lg-0"> Controller Loading Time: {{ $backend_loading_time }}</p>

            </div>
            <h1 class="mb-2 mb-lg-0">
                All Products
            </h1>
            <nav class="breadcrumbs">
                <ol>

                    <li><a href="{{ route('frontend.product-showcase-cached.index') }}">All</a></li>
                    @foreach ($product_categories as $category)
                        <li><a href="{{ route('frontend.product-showcase-cached.index', $category->slug) }}">{{ $category->title }}</a></li>
                    @endforeach
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <!-- Services Section -->
    <section id="services" class="services section">

        <div class="container">

            <div class="row gy-4">

                @foreach ($products as $product)
                    <div class="col-md-6">
                        <div class="service-item d-flex position-relative h-100">
                            <img src="{{ asset($product->banner) }}" alt="Product Image" class="img-2x1">

                            <div class="pl-5">
                                <h4 class="title"><a href="{{ route('frontend.product.details.cached', $product->slug) }}"
                                        class="stretched-link">{{ $product->title }}</a></h4>
                                <p class="">Price: {{ $product->price }} Tk
                                <p class="description">{{ $product->short_description }}</p>
                            </div>
                        </div>
                    </div><!-- End Service Item -->
                @endforeach
            </div>

            {{ $products->links() }}

        </div>

    </section><!-- /Services Section -->
@endsection
