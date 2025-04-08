<div>
    <h2>Order Details</h2>

    @if ($items->isNotEmpty())
        <div class="mb-4">
            <h5 class="mb-3">Shipping Address</h5>
            <div class="p-3 border rounded-3">
                {!! $address !!}
            </div>
        </div>
        <h5 class="mb-3">Product Details</h5>
        <div class="table-responsive">
            <table class="table text-center">
                <thead>
                    <tr>
                        <th class="text-start" scope="col" style="width: 24%;">Product</th>
                        <th scope="col" style="width: 14%;">Quantity</th>
                        <th scope="col" style="width: 19%;">Unit Price</th>
                        <th scope="col" style="width: 19%;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td class="text-start" scope="row">
                                <div class="d-flex align-items-start">
                                    <!-- Image on the Left -->
                                    <div class="me-3">
                                        <img src="{{ asset('storage/' . $item->product->images->first()->image_path) }}"
                                            alt="{{ $item->product->name }}" class="img-fluid rounded-3"
                                            style="width: 160px; height: 160px; object-fit: cover;" />
                                    </div>
                                    <!-- Details on the Right -->
                                    <div class="flex-grow-1 d-flex flex-column justify-between">
                                        <div class="mb-2">
                                            <h6 class="fw-bold mb-1 text-truncate">{{ $item->product->name }}</h6>
                                        </div>
                                        <div class="mb-2">
                                            <div class="d-flex align-items-center">
                                                <span class="text-muted me-2">Color:</span>
                                                <span class="text-primary">{{ $item->color }}</span>
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <div class="d-flex align-items-center">
                                                <span class="text-muted me-2">Size:</span>
                                                <span class="text-secondary">{{ $item->size }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $item->quantity }}</td>
                            <td>RM{{ number_format($item->price_per_unit, 2) }}</td>
                            <td>RM{{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No items found for this order.</p>
    @endif
</div>
