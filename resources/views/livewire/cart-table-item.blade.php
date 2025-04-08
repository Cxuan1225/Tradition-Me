<tr wire:key="cart-item-{{ $item->id }}">
    <td class="text-start" scope="row">
        <div class="d-flex align-items-start">
            <!-- Image on the Left -->
            <div class="me-3">
                <img style="width: 160px; height: 160px; object-fit: cover; border-radius: 8px;"
                    src="{{ asset('storage/' . $item->product->images->first()->image_path) }}" class="img-fluid"
                    alt="{{ $item->product->name }}" />
            </div>
            <!-- Details on the Right -->
            <div class="flex-grow-1 d-flex flex-column justify-between">
                <div class="mb-2">
                    <h6 class="fw-bold mb-1">{{ $item->product->name }}</h6>
                </div>
                <div class="mb-2">
                    <label for="color-select-{{ $item->id }}" class="form-label fw-semibold">Select Color</label>
                    <select id="color-select-{{ $item->id }}" name="color" class="form-select small"
                        wire:model.live="selectedColor">
                        <option class="text-secondary" value="">Select a color</option>
                        @foreach ($item->product->colors as $color)
                            <option class="text-secondary" value="{{ $color->color }}"
                                {{ $color->color == $item->color ? 'selected' : '' }}>
                                {{ ucfirst($color->color) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-2">
                    <label for="size-select-{{ $item->id }}" class="form-label fw-semibold">Select Size</label>
                    <select id="size-select-{{ $item->id }}" name="size" class="form-select small"
                        wire:model.live="selectedSize">
                        @foreach ($sizes as $size)
                            <option value="{{ $size->size }}" {{ $size->size == $item->size ? 'selected' : '' }}>
                                {{ ucfirst($size->size) }} ({{ $size->quantity }} in stock)
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <input type="hidden" name="product_id" value="{{ $item->product->id }}">
        </div>
    </td>
    <td class="text-center">
        <input wire:change="changeQuantity($event.target.value)" type="number" class="form-control text-center mx-auto"
            value="{{ $quantity }}" min="1" step="1" aria-label="Quantity" style="width: 75px;">
    </td>
    <td class="text-center">RM{{ number_format($item->product->price, 2) }}</td>
    <td class="text-center" wire:model.live="totalPrice">RM{{ $totalPrice }}</td>
    <td class="text-center">
        <button class="btn btn-outline-danger btn-sm" wire:click="removeItem('{{ $item->id }}')">
            Remove
        </button>
    </td>
</tr>
