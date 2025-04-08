<footer id="footer" class="overflow-hidden   py-5">
    <div class="container">
        <div class="row d-flex flex-wrap justify-content-between">
            <div class="col-lg-3 col-sm-6 pb-3">
                <div class="footer-menu">
                    <img src="{{ asset('Logo-removebg.png') }}" alt="logo" style="width: 70px; height: 70px;">
                    <p>Discover the Richness of Our Traditions. Connect, Preserve, and Celebrate with Us.</p>
                </div>
            </div>
            <div class="col-lg-2 col-sm-6 pb-3">
                <div class="footer-menu text-uppercase">
                    <h5 class="widget-title pb-2">Quick Links</h5>
                    <ul class="menu-list list-unstyled">
                        <li class="menu-item pb-2">
                            <a href="{{ route('end_user.product.showCategory', 'Malay') }}">Malay
                                Products
                            </a>
                        </li>
                        <li class="menu-item pb-2">
                            <a href="{{ route('end_user.product.showCategory', 'Chinese') }}">Chinese
                                Products
                            </a>
                        </li>
                        <li class="menu-item pb-2">
                            <a href="{{ route('end_user.product.showCategory', 'Indian') }}">Indian
                                Products
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 pb-3">
                <div class="footer-menu contact-item">
                    <h5 class="widget-title text-uppercase pb-2">Contact Us</h5>
                    <p>Have queries or suggestions? <a href="mailto:jay1225@1utar.my"
                            class="">jay1225@1utar.my</a></p>
                    <p>Need support? Call us at <a href="tel:+60123406739" class="">+6012-3406739</a></p>
                </div>
            </div>
        </div>
    </div>
    <hr class="border-light">
    <div id="footer-bottom" class="pt-3">
        <div class="container">
            <div class="row d-flex flex-wrap justify-content-between align-items-center">
                <div class="col-md-4 col-sm-6">
                    <div class="payment-method d-flex align-items-center">
                        <p class="mb-0">Payment options:</p>
                        <div class="card-wrap ps-2 d-flex align-items-center">
                            <img src="{{ asset('enduser/images/visa.jpg') }}" alt="Visa" class="me-2"
                                style="width: 40px;">
                            <img src="{{ asset('enduser/images/mastercard.jpg') }}" alt="Mastercard" class="me-2"
                                style="width: 40px;">
                            <img src="{{ asset('enduser/images/unionpay.png') }}" alt="UnionPay" style="width: 40px;">
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 text-center text-md-end">
                    <p class="mb-0">© Copyright 2024 TraditionMe.</p>
                </div>
            </div>
        </div>
    </div>
</footer>
