@extends('layouts.end_user.app')

@section('content')
    <section class="py-5">
        <div class="container px-4 px-lg-5 my-5">
            @livewire('product-show', ['productId' => $product->id])
        </div>
    </section>
@endsection
