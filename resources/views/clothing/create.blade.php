@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 flex justify-center items-center py-12 px-4">

        <!-- Form Container -->
        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg w-full max-w-lg p-10 space-y-8">

            <!-- Form Title -->
            <h2 class="text-3xl font-extrabold text-center text-gray-800 dark:text-white">
                Add New Clothing
            </h2>

            <!-- Form -->
            <form action="{{ route('clothing.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf

    <!-- Category Selection -->
    <div class="relative">
        <label for="category" class="text-sm font-medium text-gray-600 dark:text-gray-200">Category</label>
        <select name="category_id" id="category" required
            class="w-full p-4 mt-2 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100 rounded-lg shadow-sm border-2 border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300 ease-in-out">
            <option value="" disabled selected>Select Category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>

        @error('category_id')
            <span class="text-sm text-red-500">{{ $message }}</span>
        @enderror
    </div>

    <!-- Clothing Name Input -->
    <div class="relative">
        <label for="name" class="text-sm font-medium text-gray-600 dark:text-gray-200">Clothing Name</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}" required
            class="w-full p-4 mt-2 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100 rounded-lg shadow-sm border-2 border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300 ease-in-out">

        @error('name')
            <span class="text-sm text-red-500">{{ $message }}</span>
        @enderror
    </div>

    <!-- Clothing Color Input -->
    <div class="relative">
        <label for="color" class="text-sm font-medium text-gray-600 dark:text-gray-200">Clothing Color</label>
        <input type="text" name="color" id="color" value="{{ old('color') }}" required
            class="w-full p-4 mt-2 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100 rounded-lg shadow-sm border-2 border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300 ease-in-out">

        @error('color')
            <span class="text-sm text-red-500">{{ $message }}</span>
        @enderror
    </div>

    <!-- Clothing Image Input -->
    <div class="relative">
        <label for="image" class="text-sm font-medium text-gray-600 dark:text-gray-200">Clothing Image</label>
        <input type="file" name="image" id="image" required
            class="w-full p-4 mt-2 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100 rounded-lg shadow-sm border-2 border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300 ease-in-out">

        @error('image')
            <span class="text-sm text-red-500">{{ $message }}</span>
        @enderror
    </div>

    <!-- Submit Button -->
    <div class="relative">
        <button type="submit" class="w-full py-3 mt-6 bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 text-white text-lg rounded-lg shadow-md hover:from-blue-600 hover:via-blue-700 hover:to-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-500 transition-all duration-300 ease-in-out">
            Save Clothing
        </button>
    </div>
</form>

        </div>

    </div>
@endsection
