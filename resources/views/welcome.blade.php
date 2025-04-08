@extends('layouts.end_user.app')

@section('content')
    <section id="billboard" class="position-relative overflow-hidden bg-light-blue">
        <div class="container">
            <div class="row d-flex align-items-center">
                <div class="col-md-6">
                    <div class="banner-content">
                        <h1 class="display-2 text-uppercase text-dark pb-5">Embrace Our Heritage.</h1>
                        <a href="{{ route('end_user.product.showAll') }}"
                            class="btn btn-medium btn-dark text-uppercase btn-rounded-none">Shop
                            Product</a>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="image-holder">
                        <img src="{{ asset('enduser/images/MalaysiaTraditionalAttire.png') }}" alt="banner">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="company-services" class="padding-large">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 pb-3">
                    <div class="icon-box d-flex">
                        <div class="icon-box-icon pe-3 pb-3">
                            <svg class="quality">
                                <use xlink:href="#quality" />
                            </svg>
                        </div>
                        <div class="icon-box-content">
                            <h3 class="card-title text-uppercase text-dark">Quality Guarantee</h3>
                            <p>We pride ourselves on offering products of the highest quality. Each item undergoes rigorous
                                quality checks to ensure you receive only the best, so you can shop with confidence.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 pb-3">
                    <div class="icon-box d-flex">
                        <div class="icon-box-icon pe-3 pb-3">
                            <svg class="shield-plus">
                                <use xlink:href="#shield-plus" />
                            </svg>
                        </div>
                        <div class="icon-box-content">
                            <h3 class="card-title text-uppercase text-dark">100% Secure Payment</h3>
                            <p>Your security is our top priority. We use advanced encryption and security protocols to
                                ensure that your payment information is fully protected, giving you peace of mind with every
                                transaction.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 pb-3">
                    <div class="icon-box d-flex">
                        <div class="icon-box-icon pe-3 pb-3">
                            <svg class="support">
                                <use xlink:href="#support" />
                            </svg>
                        </div>
                        <div class="icon-box-content">
                            <h3 class="card-title text-uppercase text-dark">Cultural Diversity</h3>
                            <p>We celebrate the rich tapestry of cultures by offering a diverse range of traditional attire
                                from
                                various cultures. Our platform fosters appreciation and respect for cultural heritage
                                through our
                                extensive collection of traditional garments.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 pb-3">
                    <div class="icon-box d-flex">
                        <div class="icon-box-icon pe-3 pb-3">
                            <svg class="cart-outline">
                                <use xlink:href="#cart-outline" />
                            </svg>
                        </div>
                        <div class="icon-box-content">
                            <h3 class="card-title text-uppercase text-dark">Free Delivery</h3>
                            <p>Enjoy the convenience of free delivery on all orders. We ensure that your purchases arrive at
                                your doorstep without any additional cost, making shopping with us even more enjoyable.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-product-display-section id="malay-products" title="Malay Products" :products="$malayProducts" />

    <x-product-display-section id="chinese-products" title="Chinese Products" :products="$chineseProducts" />

    <x-product-display-section id="indian-products" title="Indian Products" :products="$indianProducts" />
@endsection


@section('scripts')
    <script>
        var swiper = new Swiper('.swiper', {
            slidesPerView: 3,
            spaceBetween: 30,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });
    </script>
@endsection
