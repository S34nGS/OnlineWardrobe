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
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <h2 class="text-2xl font-semibold mb-4 text-center">{{ $category->name }}</h2>

                        <!-- Debugging: Output the number of clothing items in this category -->
                        <p class="text-center text-gray-500 mb-4">
                            Number of clothing items in this category: 
                            {{ count($groupedClothings->get($category->id, [])) }}
                        </p>

                        <div class="flex flex-wrap justify-center gap-4"> <!-- Centering the items -->

                            <!-- Loop through the clothing items that belong to this category -->
                            @if(isset($groupedClothings[$category->id]))
                                @foreach ($groupedClothings[$category->id] as $clothing)
                                    <div class="border p-4 rounded-lg shadow-sm hover:shadow-md flex flex-col items-center">
                                        <!-- Center the image in the box -->
                                        <img src="{{ asset('storage/' . $clothing->file_path) }}" alt="{{ $clothing->name }}" class="w-32 h-32 object-cover mx-auto mb-4 rounded-lg shadow-md">
                                        <p class="text-center text-lg font-semibold">
                                            {{ $clothing->name }} 
                                            <span class="text-sm text-gray-500">({{ $clothing->color }})</span>
                                        </p>
                                    </div>
                                @endforeach
                            @endif

                        </div>
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
                <a href="{{ route('clothing.create') }}" class="bg-blue-500 text-white py-3 px-6 rounded-md shadow-md hover:bg-blue-600 w-full transition duration-300 ease-in-out">
                    Add New Clothing
                </a>
            </div>

        </div>

    </div>
@endsection
