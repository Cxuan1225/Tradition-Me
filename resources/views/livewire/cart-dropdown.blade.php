<li class="nav-item dropdown pe-3">
    <a class="nav-link" data-bs-toggle="dropdown" href="#" aria-label="Shopping Cart">
        <div class="d-flex align-items-center position-relative">
            <svg class="cart">
                <use xlink:href="#cart"></use>
            </svg>
            <span class="badge rounded-pill bg-danger position-absolute top-0 start-100 translate-middle badge-number">
                {{ $totalCartItems }}
            </span>
        </div>
    </a>

    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-3" style="max-width: 320px;">
        @if ($cartItems->isNotEmpty())
            <h6 class="dropdown-header">{{ $totalCartItems }} Items in Cart</h6>
            <div class="cart-items" style="overflow-y: auto; max-height: 300px;">
                <div class="dropdown-divider"></div>
                @foreach ($cartItems as $item)
                    <div class="dropdown-item d-flex align-items-center py-2">
                        <div class="d-flex align-items-center me-3" style="width: 70px;">
                            <img src="{{ asset('storage/' . $item->product->images->first()->image_path) }}"
                                alt="{{ $item->product->name }}" class="img-fluid rounded"
                                style="height: 50px; width: 50px; object-fit: cover;">
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="dropdown-item-title mb-1 text-truncate" style="font-size: 14px;">
                                {{ $item->product->name }}
                            </h6>
                            <p class="text-muted mb-1 text-sm" style="font-size: 12px;">
                                RM{{ $item->product->price }} x {{ $item->quantity }}
                            </p>
                            <p class="text-muted mb-1 text-sm" style="font-size: 12px;">
                                Color: {{ $item->color }} | Size: {{ $item->size }}
                            </p>
                        </div>
                    </div>
                    @if (!$loop->last)
                        <div class="dropdown-divider"></div>
                    @endif
                @endforeach

            </div>
        @else
            <div class="dropdown-item">No items in cart</div>
        @endif
        <div class="dropdown-divider"></div>
        <a href="{{ route('end_user.cart.index') }}" class="dropdown-item text-center">View Cart Summary</a>
    </div>
</li>
