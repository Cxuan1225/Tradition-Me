@extends($layout)
@section('content')
    <div class="container" style="padding-top: 120px;">
        @livewire('order-table-details', ['orderId' => $orderId])
    </div>
@endsection
