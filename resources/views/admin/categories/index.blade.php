@extends('layouts.admin')

@section('page-title', 'Categories Management')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-bold">Categories</h1>
    <a href="{{ route('admin.categories.create') }}" class="btn-primary">
        + Add New Category
    </a>
</div>

<div class="bg-white rounded-lg shadow">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Slug</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Products</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($categories as $category)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm">{{ $category->id }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <span class="text-2xl mr-2">{{ $category->icon ?? '📦' }}</span>
                                <span class="font-semibold">{{ $category->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $category->slug }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="bg-primary-100 text-primary-800 px-2 py-1 rounded font-semibold">
                                {{ $category->products_count }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <form action="{{ route('admin.categories.toggle', $category->id) }}" method="POST">
                                @csrf
                                @if($category->is_active)
                                    <button type="submit" class="bg-green-100 text-green-800 px-3 py-1 rounded text-sm font-semibold hover:bg-green-200">
                                        Active
                                    </button>
                                @else
                                    <button type="submit" class="bg-red-100 text-red-800 px-3 py-1 rounded text-sm font-semibold hover:bg-red-200">
                                        Inactive
                                    </button>
                                @endif
                            </form>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="text-primary-600 hover:text-primary-800 font-semibold text-sm">
                                    Edit
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-semibold text-sm" onclick="return confirm('Delete this category?')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            No categories found. Create your first category!
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="px-6 py-4 border-t">
        {{ $categories->links() }}
    </div>
</div>
@endsection