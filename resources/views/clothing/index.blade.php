@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-100 flex items-center justify-center py-8">

        <!-- Main Container for Clothing Sections and Buttons -->
        <div class="container mx-auto flex space-x-8">

            <!-- Clothing Categories Section (Vertically Centered) -->
            <div class="flex flex-col space-y-12 w-full lg:w-3/4">

                <!-- Petten / Hoeden Section -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h2 class="text-2xl font-semibold mb-4 text-center">Petten & Hoeden</h2>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach ($clothings->where('category_id', 1) as $clothing)
                            <div class="border p-4 rounded-lg shadow-sm hover:shadow-md">
                                <img src="{{ asset('storage/' . $clothing->file_path) }}" alt="{{ $clothing->name }}" class="w-32 h-32 object-cover mx-auto mb-2">
                                <p class="text-center text-lg">{{ $clothing->name }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- T-Shirts / Jassen Section -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h2 class="text-2xl font-semibold mb-4 text-center">T-Shirts & Jassen</h2>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach ($clothings->where('category_id', 2) as $clothing)
                            <div class="border p-4 rounded-lg shadow-sm hover:shadow-md">
                                <img src="{{ asset('storage/' . $clothing->file_path) }}" alt="{{ $clothing->name }}" class="w-32 h-32 object-cover mx-auto mb-2">
                                <p class="text-center text-lg">{{ $clothing->name }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Broeken Section -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h2 class="text-2xl font-semibold mb-4 text-center">Broeken</h2>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach ($clothings->where('category_id', 3) as $clothing)
                            <div class="border p-4 rounded-lg shadow-sm hover:shadow-md">
                                <img src="{{ asset('storage/' . $clothing->file_path) }}" alt="{{ $clothing->name }}" class="w-32 h-32 object-cover mx-auto mb-2">
                                <p class="text-center text-lg">{{ $clothing->name }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Schoenen Section -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h2 class="text-2xl font-semibold mb-4 text-center">Schoenen</h2>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach ($clothings->where('category_id', 4) as $clothing)
                            <div class="border p-4 rounded-lg shadow-sm hover:shadow-md">
                                <img src="{{ asset('storage/' . $clothing->file_path) }}" alt="{{ $clothing->name }}" class="w-32 h-32 object-cover mx-auto mb-2">
                                <p class="text-center text-lg">{{ $clothing->name }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

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
                <a href="{{ route('clothing.create') }}" class="bg-blue-500 text-white py-3 px-6 rounded-md shadow-md hover:bg-blue-600 w-full text-center transition duration-300 ease-in-out">
                Add New Clothing
                </a>

            </div>

        </div>

    </div>
@endsection
