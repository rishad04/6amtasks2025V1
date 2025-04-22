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
                Product Details
            </h1>

            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('frontend.landing.index') }}">Home</a></li>
                    <li class="current">product Details </li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <div class="container">
        <div class="row">

            <div class="col-lg-8">

                <!-- Blog Details Section -->
                <section id="blog-details" class="blog-details section">
                    <div class="container">

                        <article class="article">

                            <div class="post-img">
                                <img src="{{ asset($product->banner ?? avatarUrl()) }}" alt="" class="img-fluid">
                            </div>

                            <h2 class="title">{{ $product->title }}</h2>
                            <h3 class="category">{{ $product->productCategory?->title }}</h3>

                            <div class="content">

                                <p>
                                    {{ $product->description }}
                                </p>

                                <blockquote>
                                    <p>
                                        {{ $product->short_description }}
                                    </p>
                                </blockquote>

                            </div><!-- End post content -->

                        </article>

                        <div class="meta-bottom">
                            <i class="bi bi-folder"></i>
                            <ul class="cats">
                                <li><a href="#">Business</a></li>
                            </ul>

                            <i class="bi bi-tags"></i>
                            <ul class="tags">
                                <li><a href="#">Creative</a></li>
                                <li><a href="#">Tips</a></li>
                                <li><a href="#">Marketing</a></li>
                            </ul>
                        </div><!-- End meta bottom -->

                    </div>
                </section><!-- /Blog Details Section -->
            </div>

            <div class="col-lg-4 sidebar">

                <div class="widgets-container">

                    <!-- Categories Widget -->
                    <div class="categories-widget widget-item">

                        <h3 class="widget-title">Categories </h3>
                        <ul class="mt-3">

                            @foreach ($product_categories as $category)
                                <li><a href="{{ route('frontend.product-showcase.index', $category->slug) }}">{{ $category->title }}<span>({{ $category->product()->count() }}
                                            Items)</span></a></li>
                            @endforeach
                        </ul>

                    </div><!--/Categories Widget -->

                    <!-- Recent Posts Widget -->
                    <div class="recent-posts-widget widget-item">

                        <h3 class="widget-title">Recent Products</h3>

                        @foreach ($latest_products as $item)
                            <div class="post-item">
                                <img src="{{ asset($item->banner) }}" alt="" class="flex-shrink-0 br-10">
                                <div>
                                    <h4><a href="{{ route('frontend.product.details', $item->slug) }}">{{ $item->title }}</a></h4>
                                    <h6><a href="#">{{ $item->productCategory?->title }}</a></h6>
                                    <time datetime="2020-01-01">{{ $item->price }} Tk</time>
                                </div>
                            </div><!-- End recent post item-->
                        @endforeach

                        <div class="post-item">
                            <div>
                                <h4><a href="{{ route('frontend.product-showcase.index') }}">View All</a></h4>
                                {{-- <h6><a href="#">{{ $item->productCategory?->title }}</a></h6>
                                <time datetime="2020-01-01">{{ $item->price }} Tk</time> --}}
                            </div>
                        </div><!-- End recent post item-->

                    </div><!--/Recent Posts Widget -->

                </div>

            </div>
        @endsection
