@extends('layouts.admin_seller.app')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 d-flex justify-content-between align-items-center">
                <div class="col-sm-6">
                    <h1 class="mb-0">Product List</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <!-- Add Product Button -->
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createProductModal">
                        Add Product
                    </button>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title mb-0">Product List</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="productTable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Index</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if (!empty($product->images) && isset($product->images[0]))
                                                    <a href="{{ asset('storage/' . $product->images[0]->image_path) }}"
                                                        data-lightbox="product-{{ $product->id }}"
                                                        data-title="{{ htmlspecialchars($product->name) }}">
                                                        <img src="{{ asset('storage/' . $product->images[0]->image_path) }}"
                                                            alt="{{ htmlspecialchars($product->name) }}"
                                                            class="img-thumbnail" style="width: 150px; height: 150px;">
                                                    </a>
                                                    @foreach ($product->images as $key => $image)
                                                        @if ($key > 0)
                                                            <a href="{{ asset('storage/' . $image->image_path) }}"
                                                                data-lightbox="product-{{ $product->id }}"
                                                                data-title="{{ htmlspecialchars($product->name) }}"
                                                                style="display: none;">
                                                                <img src="{{ asset('storage/' . $image->image_path) }}"
                                                                    alt="{{ htmlspecialchars($product->name) }}"
                                                                    class="img-thumbnail">
                                                            </a>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>{{ $product->name }}</td>
                                            <td
                                                style="width:300px; word-wrap:break-word; white-space:normal; text-align:justify;">
                                                {{ $product->description }}</td>
                                            <td>{{ $product->category }}</td>
                                            <td>{{ $product->price }}</td>
                                            <td>{{ $product->stock_quantity }}</td>
                                            <td>
                                                @include('admin.product.edit')
                                                @include('admin.product.delete')
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
    @include('admin.product.create')
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#productTable').DataTable({
                responsive: true,
                lengthChange: true,
                autoWidth: false,
                pageLength: 5,
                search: true,
            });
        });
    </script>
@endsection
