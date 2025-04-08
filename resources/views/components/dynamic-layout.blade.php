@php
    $role = Auth::user()->role === 'end_user' ? 'layouts.end_user.app' : 'layouts.admin_seller.app';
    $layout = Session::get('view_layout', $role);
@endphp

@extends($layout)

@section('content')
    {{ $slot }}
@endsection
