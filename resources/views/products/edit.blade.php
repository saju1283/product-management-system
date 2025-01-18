@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-dark text-white">
            <h4>Edit Product</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Product ID -->
                <div class="mb-3">
                    <label for="product_id" class="form-label">Product ID</label>
                    <input type="text" name="product_id" id="product_id" class="form-control" value="{{ $product->product_id }}" required>
                </div>

                <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}" required>
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="4">{{ $product->description }}</textarea>
                </div>

                <!-- Price -->
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" name="price" id="price" class="form-control" step="0.01" value="{{ $product->price }}" required>
                </div>

                <!-- Stock -->
                <div class="mb-3">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number" name="stock" id="stock" class="form-control" value="{{ $product->stock }}">
                </div>

                <!-- Current Image -->
                <div class="mb-3">
                    <label for="current_image" class="form-label">Current Image</label>
                    <div>
                        <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" class="img-thumbnail" style="width: 120px; height: 120px;">
                    </div>
                </div>

                <!-- New Image Upload -->
                <div class="mb-3">
                    <label for="image" class="form-label">New Product Image</label>
                    <input type="file" name="image" id="image" class="form-control">
                    <small class="text-muted">Leave blank if you don't want to change the image.</small>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-warning">Update Product</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
