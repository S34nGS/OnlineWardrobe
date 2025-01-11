@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-100 flex items-center justify-center py-8">

        <!-- Main Container for Clothing Sections and Buttons -->
        <div class="container mx-auto flex space-x-8">

            <!-- Clothing Categories Section (Vertically Centered) -->
            <div class="flex flex-col space-y-12 w-full lg:w-3/4">

                <!-- Loop through all categories -->
                @foreach ($categories as $category)
                    <!-- Category Section -->
                    <div class="bg-white p-6 rounded-lg shadow-lg relative">
                        <h2 class="text-2xl font-semibold mb-4 text-center">{{ $category->name }}</h2>

                        <!-- Get the most recent clothing item for this category -->
                        @php
                            $clothing = \App\Models\Clothing::where('category_id', $category->id)->latest()->first();
                        @endphp

                        @if ($clothing)
                            <div class="flex flex-wrap justify-center gap-4">
                                <!-- Display the most recent clothing item for the category -->
                                <div class="border p-4 rounded-lg shadow-sm hover:shadow-md flex flex-col items-center">
                                    <img src="{{ asset('storage/' . $clothing->file_path) }}" alt="{{ $clothing->name }}" class="w-36 h-36 object-cover mx-auto rounded-lg shadow-md transition-transform transform hover:scale-105 duration-300 ease-in-out">
                                    <p class="text-center text-lg font-semibold text-gray-800">
                                        {{ $clothing->name }}
                                        <span class="text-sm text-gray-500">({{ $clothing->color }})</span>
                                    </p>
                                </div>
                            </div>

                            <!-- Revert Button for Previous Image (Positioned in the Top Left) -->
                            @if ($clothing->file_path)
                                <form action="{{ route('clothing.revert', $clothing->id) }}" method="POST" class="absolute top-4 left-4">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="bg-yellow-500 text-white py-2 px-4 rounded-md transition duration-300 ease-in-out hover:bg-yellow-600">
                                        Revert to Previous Image
                                    </button>
                                </form>
                            @endif
                        @else
                            <p class="text-center text-gray-500">No clothing available in this category.</p>
                        @endif
                    </div>
                @endforeach

            </div>

            <!-- Right Side: Buttons (Randomize and Save) -->
            <div class="flex flex-col items-center space-y-6 w-1/4 px-4">
                <button class="bg-blue-600 text-white py-3 px-6 rounded-md shadow-md hover:bg-blue-700 w-full transition duration-300 ease-in-out">
                    Randomize
                </button>
                <button class="bg-green-600 text-white py-3 px-6 rounded-md shadow-md hover:bg-green-700 w-full transition duration-300 ease-in-out">
                    Save
                </button>

                <!-- Add New Clothing Button -->
                <a href="{{ route('clothing.create') }}" class="bg-blue-500 text-white py-3 px-6 rounded-md shadow-md hover:bg-blue-600 w-full text-center flex justify-center items-center">
                    Add New Clothing
                </a>
            </div>

        </div>

    </div>
@endsection
