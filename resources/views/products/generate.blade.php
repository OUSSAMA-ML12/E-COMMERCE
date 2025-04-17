@extends('layout.app')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Generate Product</h2>

    {{-- First Form: Generate Product --}}
    <div class="card p-4">
        <form id="generateForm" method="GET">
            @csrf
            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="keys" class="form-label">Keywords (comma-separated)</label>
                <input type="text" id="keys" name="keys" class="form-control" required>
            </div>

            <button type="button" class="btn btn-primary" id="generateBtn">Generate Product</button>
        </form>
    </div>
</div>

<script>
    document.getElementById('generateBtn').addEventListener('click', function() {
        let category = document.getElementById('category_id').value;
        let keys = document.getElementById('keys').value;

        if (!category || !keys) {
            alert("Please select a category and enter keywords.");
            return;
        }

        let url = "{{ url('/generate-product') }}" + '/' + encodeURIComponent(category) + '/' + encodeURIComponent(keys);
        document.getElementById('generateForm').action = url;
        document.getElementById('generateForm').submit();
    });
</script>

@endsection
