<div class="card product-card shadow-sm border-0" style="width: 315px; border-radius: 12px;">
    <img src="{{ $product->images->first() ? asset('storage/' . $product->images->first()->image_path) : 'default-image.jpg' }}"
        class="card-img-top" alt="{{ $product->name }}" style="height: 315px; object-fit: cover; border-radius: 12px;">
    <div class="card-body d-flex flex-column p-3">
        <h5 class="card-title mb-2">
            <a href="{{ route('end_user.product.show', $product->id) }}"
                class="text-dark text-decoration-none fw-bold">{{ $product->name }}</a>
        </h5>
        <p class="card-text text-primary fs-5 mb-3">RM{{ $product->price }}</p>
        <div class="mt-auto">
            <a href="#"
                class="btn btn-dark w-100 mb-2 d-flex align-items-center justify-content-center rounded-pill"
                data-bs-toggle="modal" data-bs-target="#cartModal{{ $product->id }}">
                <svg class="bi bi-cart me-2" width="16" height="16" fill="currentColor">
                    <use xlink:href="#cart-outline"></use>
                </svg>
                Add to Cart
            </a>
            <a href="#"
                class="btn btn-primary btn-alt w-100 d-flex align-items-center justify-content-center rounded-pill"
                data-bs-toggle="modal" data-bs-target="#buyModal{{ $product->id }}">
                <svg class="bi bi-bag-check me-2" width="16" height="16" fill="currentColor">
                    <use xlink:href="#bag-check-outline"></use>
                </svg>
                Buy Now
            </a>
        </div>
    </div>
</div>


@livewire('cart-modal', ['productId' => $product->id, 'display' => 0])
@livewire('cart-modal', ['productId' => $product->id, 'display' => 1])
