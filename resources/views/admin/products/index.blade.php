@extends('layouts.admin')

@section('page-title', 'Products Management')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-bold">Products</h1>
    <a href="{{ route('admin.products.create') }}" class="btn-primary">
        + Add New Product
    </a>
</div>

<div class="bg-white rounded-lg shadow">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Image</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Stock</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($products as $product)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded">
                            @else
                                <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                    <span class="text-gray-400">📦</span>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-semibold">{{ $product->name }}</p>
                            <p class="text-xs text-gray-600">SKU: {{ $product->sku }}</p>
                            @if($product->weight)
                                <p class="text-xs text-gray-600">{{ $product->weight }}</p>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm">{{ $product->category->name }}</td>
                        <td class="px-6 py-4 font-semibold">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            @if($product->stock > 10)
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm font-semibold">
                                    {{ $product->stock }}
                                </span>
                            @elseif($product->stock > 0)
                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-sm font-semibold">
                                    {{ $product->stock }}
                                </span>
                            @else
                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-sm font-semibold">
                                    Out
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <form action="{{ route('admin.products.toggle', $product->id) }}" method="POST">
                                @csrf
                                @if($product->is_active)
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
                            <div class="flex flex-col space-y-1">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="text-primary-600 hover:text-primary-800 font-semibold text-sm">
                                    Edit
                                </a>
                                @if($product->qr_code)
                                    <a href="{{ route('admin.products.qr.download', $product->id) }}" class="text-blue-600 hover:text-blue-800 font-semibold text-sm">
                                        Download QR
                                    </a>
                                @endif
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-semibold text-sm" onclick="return confirm('Delete this product?')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            No products found. Create your first product!
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="px-6 py-4 border-t">
        {{ $products->links() }}
    </div>
</div>
@endsection