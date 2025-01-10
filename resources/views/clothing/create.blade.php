// resources/views/clothing/create.blade.php

@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-2xl font-semibold mb-6">Add New Clothing</h1>

        <!-- Make sure to add enctype="multipart/form-data" to the form for image uploads -->
        <form action="{{ route('clothing.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Name Field -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="name" name="name" class="mt-1 block w-full border border-gray-300 rounded-md" required>
            </div>

            <!-- Color Field -->
            <div class="mb-4">
                <label for="color" class="block text-sm font-medium text-gray-700">Color</label>
                <input type="text" id="color" name="color" class="mt-1 block w-full border border-gray-300 rounded-md" required>
            </div>

            <!-- Category Field -->
            <div class="mb-4">
                <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                <select id="category_id" name="category_id" class="mt-1 block w-full border border-gray-300 rounded-md" required>
                    <option value="">Select a category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Image Upload Field -->
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700">Upload Image</label>
                <input type="file" id="image" name="image" class="mt-1 block w-full border border-gray-300 rounded-md" accept="image/*" required>
            </div>

            <!-- Submit Button -->
            <div class="mb-4">
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md">Save Clothing</button>
            </div>
        </form>
    </div>
@endsection
