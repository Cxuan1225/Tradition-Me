<div>
    <input type="text" wire:model.live.debounce.250ms="search" placeholder="Search products..."
        class="form-control mb-3" />
    <div wire:ignore.self class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach ($products as $product)
            <div class="col">
                @include('components.product-card', ['product' => $product])
            </div>
        @endforeach
    </div>
</div>
