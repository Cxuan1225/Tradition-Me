@extends('layouts.end_user.app')

@section('content')
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5 pt-4">
            @if (isset($products->first()->category))
                <h2 class="text-center mb-4"
                    style="font-size: 2rem; font-weight: 700; color: #2c3e50; text-transform: uppercase; letter-spacing: 0.1em;">
                    {{ $products->first()->category }} Products
                </h2>
                @livewire('product-search', ['category' => $products->first()->category])
            @else
                <h2 class="text-center mb-4"
                    style="font-size: 2rem; font-weight: 700; color: #e74c3c; text-transform: uppercase; letter-spacing: 0.1em;">
                    No products available in this category.
                </h2>
            @endif
        </div>
    </section>
@endsection
