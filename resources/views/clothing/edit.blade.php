@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-100 flex items-center justify-center py-8">

        <div class="container mx-auto w-full max-w-lg">
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-semibold text-center mb-6">Edit Clothing</h2>

                <!-- Clothing Edit Form -->
                <form method="POST" action="{{ route('clothing.update', $clothing->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Clothing Name -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $clothing->name) }}" class="mt-1 block w-full p-2 rounded-lg border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <!-- Clothing Color -->
                    <div class="mb-4">
                        <label for="color" class="block text-sm font-medium text-gray-700">Color</label>
                        <input type="text" id="color" name="color" value="{{ old('color', $clothing->color) }}" class="mt-1 block w-full p-2 rounded-lg border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <!-- Category -->
                    <div class="mb-4">
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                        <select id="category_id" name="category_id" class="mt-1 block w-full p-2 rounded-lg border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ $clothing->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Image Upload -->
                    <div class="mb-4">
                        <label for="image" class="block text-sm font-medium text-gray-700">Upload New Image (Optional)</label>
                        <input type="file" id="image" name="image" class="mt-1 block w-full p-2 rounded-lg border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Previous Image Selection (Revert to Previous) -->
                    @if ($previousClothes->count() > 0)
                        <div class="mb-4">
                            <label for="previous_image_id" class="block text-sm font-medium text-gray-700">Revert to Previous Image</label>
                            <select id="previous_image_id" name="previous_image_id" class="mt-1 block w-full p-2 rounded-lg border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Previous Image</option>
                                @foreach ($previousClothes as $previousClothing)
                                    <option value="{{ $previousClothing->id }}" {{ $clothing->file_path == $previousClothing->file_path ? 'selected' : '' }}>
                                        {{ $previousClothing->name }} ({{ $previousClothing->color }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <!-- Submit Button -->
                    <div class="mb-4">
                        <button type="submit" class="w-full bg-blue-600 text-white py-3 px-6 rounded-md shadow-md hover:bg-blue-700 transition duration-300 ease-in-out">
                            Update Clothing
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
@endsection
