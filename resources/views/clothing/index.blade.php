@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-2xl font-semibold mb-6">Clothing Items</h1>

        <!-- Link to create new clothing item -->
        <a href="{{ route('clothing.create') }}" class="bg-blue-500 text-white py-2 px-4 rounded-md mb-4">Add New Clothing</a>

        <!-- Table for displaying clothing items -->
        <table class="w-full border border-gray-300 table-auto">
            <thead>
                <tr>
                    <!-- Added column for Image -->
                    <th class="border-b p-2 text-left">Image</th> 
                    <th class="border-b p-2 text-left">Name</th>
                    <th class="border-b p-2 text-left">Color</th>
                    <th class="border-b p-2 text-left">Category</th>
                    <th class="border-b p-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clothings as $clothing)
                    <tr>
                        <td class="border-b p-2">
                            <!-- Check if the clothing has an image -->
                            @if($clothing->file_path)
                                <img src="{{ asset('storage/' . $clothing->file_path) }}" alt="{{ $clothing->name }}" class="w-16 h-16 object-cover rounded-md">
                            @else
                                <span class="text-gray-500">No image</span>
                            @endif
                        </td>
                        <td class="border-b p-2">{{ $clothing->name }}</td>
                        <td class="border-b p-2">{{ $clothing->color }}</td>
                        <td class="border-b p-2">{{ $clothing->category->name }}</td>
                        <td class="border-b p-2">
                            <!-- Action buttons for view, edit, and delete -->
                            <a href="{{ route('clothing.show', $clothing->id) }}" class="text-blue-500">View</a> |
                            <a href="{{ route('clothing.edit', $clothing->id) }}" class="text-green-500">Edit</a> |
                            <form action="{{ route('clothing.destroy', $clothing->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
