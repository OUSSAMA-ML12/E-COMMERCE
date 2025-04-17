@extends('layout.app')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Generated Product</h2>

    <div class="card p-4">
        <!-- Form start -->
        <form action="{{ route('products.generate.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Product Name -->
            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ $jsonResponse['name'] ?? '' }}" required>
            </div>

            <!-- Category -->
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <input type="text" id="category" name="category_id" class="form-control" value="{{ $category->name ?? '' }}" disabled>
                <!-- Send category ID in hidden input -->
                <input type="hidden" name="category" value="{{ $category->id }}">
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" class="form-control" rows="4" required>{{ $jsonResponse['description'] ?? '' }}</textarea>
            </div>

            <!-- Price -->
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" id="price" name="price" class="form-control" value="{{ $jsonResponse['price'] ?? 0 }}" step="0.01" required>
            </div>


            @if($filename)
                <div class="mb-3">
                    <h4>Generated Image</h4>
                    <img src="{{ asset('storage/' . $filename) }}" alt="Generated Product Image" class="img-fluid w-25 h-25">
                    <input type="hidden" name="image" class="form-control" value="{{ $filename }}">
                </div>
            @endif
           

            <div class="text-center">
                <!-- Submit Button to store data -->
                <button type="submit" class="btn btn-primary">Save Product</button>
            </div>
        </form>
        <!-- Form end -->
    </div>
</div>
@endsection
