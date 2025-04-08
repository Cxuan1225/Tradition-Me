<section id="{{ $id }}" class="product-store py-4">
    <div class="container">
        <div class="row mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="display-7 text-dark text-uppercase">{{ $title }}</h2>
                <div class="btn-right">
                    @if ($products->isNotEmpty())
                        <a href="{{ route('end_user.product.showCategory', $products->first()->category) }}"
                            class="btn btn-medium btn-normal text-uppercase">View All Products</a>
                    @else
                        <span class="btn btn-medium btn-normal text-uppercase">View All Products</span>
                    @endif
                </div>
            </div>
            <div class="row mt-4">
                @if ($products->isNotEmpty())
                    @foreach ($products as $product)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                            @include('components.product-card', ['product' => $product])
                        </div>
                    @endforeach
                @else
                    <p class="text-center">There are no products available in this category yet.</p>
                @endif
            </div>
        </div>
    </div>
</section>
