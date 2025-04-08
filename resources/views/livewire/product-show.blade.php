<div class="row gx-4 gx-lg-5 align-items-center">
    <div class="col-md-6">
        @if ($product->images->first())
            <img class="card-img-top mb-5 mb-md-0" src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                alt="{{ $product->name }}" />
        @else
            <img class="card-img-top mb-5 mb-md-0" src="default-image.jpg" alt="default product" />
        @endif
    </div>
    <div class="col-md-6">
        <h1 class="display-5 fw-bolder">{{ $product->name }}</h1>
        <div class="fs-5 mb-5">
            <span>RM{{ $product->price }}</span>
        </div>
        <div class="small mb-1">Category: {{ $product->category }}</div>
        <p class="lead">{{ $product->description }}</p>

        <form wire:submit.prevent="addToCart">
            @csrf
            <!-- Color Selection -->
            <div class="mb-3">
                <h6>Select Color</h6>
                <select name="color" class="form-select" wire:model.live="selectedColor">
                    <option value="">Select a color</option>
                    @foreach ($product->colors as $color)
                        <option value="{{ $color->color }}"{{ $color->color == $selectedColor ? 'selected' : '' }}>
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
                        <option value="{{ $size->size }}"{{ $size->size == $selectedSize ? 'selected' : '' }}>
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
                <input class="form-control text-center me-3" name="quantity" type="number" min="1"
                    max="99" wire:model="quantity" style="max-width: 80px;" />
                <button class="btn btn-outline-dark" type="submit">
                    <i class="bi-cart-fill me-1"></i> Add to Cart
                </button>
            </div>

            <input type="hidden" name="product_id" value="{{ $product->id }}">
        </form>
    </div>
</div>
