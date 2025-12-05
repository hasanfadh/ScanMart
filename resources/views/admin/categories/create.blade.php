@extends('layouts.admin')

@section('page-title', 'Add New Category')

@section('content')
<div class="max-w-2xl">
    <div class="mb-6">
        <a href="{{ route('admin.categories.index') }}" class="text-primary-600 hover:text-primary-800 font-semibold">
            ← Back to Categories
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold mb-6">Add New Category</h2>

        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Category Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" class="input-field" placeholder="e.g. Snacks, Drinks, etc." required>
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Icon (Emoji)</label>
                <input type="text" name="icon" value="{{ old('icon') }}" class="input-field" placeholder="e.g. 🍿 🥤 🍞">
                <p class="text-sm text-gray-600 mt-1">Use emoji to represent this category</p>
                @error('icon')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Description</label>
                <textarea name="description" rows="4" class="input-field" placeholder="Brief description of this category">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="btn-primary">
                    Create Category
                </button>
                <a href="{{ route('admin.categories.index') }}" class="btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection