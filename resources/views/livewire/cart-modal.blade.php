<div class="modal fade" id="{{ $display == 0 ? 'cart' : 'buy' }}Modal{{ $product->id }}" tabindex="-1"
    aria-labelledby="{{ $display == 0 ? 'cart' : 'buy' }}ModalLabel{{ $product->id }}" aria-hidden="true"
    wire:ignore.self>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="card">
                    <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" class="card-img-top"
                        alt="{{ $product->name }}" />
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <h5 class="card-title mb-0">{{ $product->name }}</h5>
                            <p class="mb-0 text-muted">RM{{ $product->price }}</p>
                        </div>
                        <div class="small mb-2">Category: {{ $product->category }}</div>
                        <p class="text-secondary lead mb-3">{{ $product->description }}</p>

                        <form wire:submit.prevent="addToCart">
                            @csrf
                            <!-- Color Selection -->
                            <div class="mb-3">
                                <h6>Select Color</h6>
                                <select name="color" class="form-select" wire:model.live="selectedColor">
                                    <option value="">Select a color</option>
                                    @foreach ($product->colors as $color)
                                        <option
                                            value="{{ $color->color }}"{{ $color->color == $selectedColor ? 'selected' : '' }}
                                            wire:click="$refresh">
                                            {{ ucfirst($color->color) }}</option>
                                    @endforeach
                                </select>
                                <div>
                                    @error('selectedColor')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Size Selection -->
                            <div class="mb-3">
                                <h6>Select Size</h6>
                                <select name="size" class="form-select" wire:model.live="selectedSize">
                                    <option value="">Select a size</option>
                                    @foreach ($sizes as $size)
                                        <option value="{{ $size->size }}"
                                            {{ $size->size == $selectedSize ? 'selected' : '' }} wire:click="$refresh">
                                            {{ ucfirst($size->size) }} ({{ $size->quantity }} in stock)
                                        </option>
                                    @endforeach
                                </select>
                                <div>
                                    @error('selectedSize')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Quantity Input -->
                            <div class="d-flex align-items-center mt-3">
                                <input wire:click="$refresh" class="form-control text-center me-3" name="quantity"
                                    type="number" min="1" max="99" wire:model="quantity"
                                    style="max-width: 80px;" value="1" />
                                @if ($display == 0)
                                    <button class="btn btn-outline-dark" type="submit">
                                        <i class="bi-cart-fill me-1"></i> Add to Cart
                                    </button>
                                @else
                                    <button class="ms-3 btn btn-outline-dark" type="button" wire:click="Payment">
                                        <i class="bi-cart-fill me-1"></i> Buy Now
                                    </button>
                                @endif
                            </div>
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
