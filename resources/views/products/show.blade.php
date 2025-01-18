@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-dark text-white">
            <h4>Product Details</h4>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <strong>Product ID:</strong> {{ $product->product_id }}
            </div>
            <div class="mb-3">
                <strong>Name:</strong> {{ $product->name }}
            </div>
            <div class="mb-3">
                <strong>Description:</strong> {{ $product->description }}
            </div>
            <div class="mb-3">
                <strong>Price:</strong> Tk. {{ number_format($product->price, 2) }}
            </div>
            <div class="mb-3">
                <strong>Stock:</strong> {{ $product->stock }}
            </div>
            <div class="mb-3">
                <strong>Image:</strong>
                <br>
                <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" class="img-thumbnail" style="width: 200px; height: 200px;">
            </div>
            <a href="{{ route('products.index') }}" class="btn btn-primary">Back to Products</a>
        </div>
    </div>
</div>
@endsection
