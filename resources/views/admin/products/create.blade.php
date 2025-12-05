@extends('layouts.admin')

@section('page-title', 'Add New Product')

@section('content')
<div class="max-w-3xl">
    <div class="mb-6">
        <a href="{{ route('admin.products.index') }}" class="text-primary-600 hover:text-primary-800 font-semibold">
            ← Back to Products
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold mb-6">Add New Product</h2>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Product Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="input-field" required>
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Category *</label>
                    <select name="category_id" class="input-field" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Description</label>
                <textarea name="description" rows="4" class="input-field">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Price (Rp) *</label>
                    <input type="number" name="price" value="{{ old('price') }}" class="input-field" step="0.01" min="0" required>
                    @error('price')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Stock *</label>
                    <input type="number" name="stock" value="{{ old('stock', 0) }}" class="input-field" min="0" required>
                    @error('stock')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Weight</label>
                    <input type="text" name="weight" value="{{ old('weight') }}" class="input-field" placeholder="e.g. 250g, 1kg">
                    @error('weight')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Pickup Location</label>
                <input type="text" name="pickup_location" value="{{ old('pickup_location') }}" class="input-field" placeholder="e.g. Aisle 3, Shelf B">
                @error('pickup_location')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Product Image</label>
                <input type="file" name="image" class="input-field" accept="image/*">
                <p class="text-sm text-gray-600 mt-1">Max 2MB (jpg, jpeg, png)</p>
                @error('image')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <p class="text-sm text-blue-800">
                    ℹ️ <strong>QR Code will be generated automatically</strong> after product creation. You can download it from the products list.
                </p>
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="btn-primary">
                    Create Product
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection