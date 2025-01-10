@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="container mx-auto bg-white p-6 rounded-lg shadow-lg grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Left side: Clothing Sections -->
            <div class="col-span-2 space-y-6">

                <!-- Petten / Hoeden Section -->
                <div class="border p-4 rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold mb-4">Petten & Hoeden</h2>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach ($clothings->where('category_id', 1) as $clothing) <!-- Assuming category_id 1 is for Petten/Hoeden -->
                            <div class="border p-4 rounded-lg shadow-sm">
                                <img src="{{ asset('storage/' . $clothing->file_path) }}" alt="{{ $clothing->name }}" class="w-32 h-32 object-cover mx-auto mb-2">
                                <p class="text-center">{{ $clothing->name }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- T-Shirts / Jassen Section -->
                <div class="border p-4 rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold mb-4">T-Shirts & Jassen</h2>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach ($clothings->where('category_id', 2) as $clothing) <!-- Assuming category_id 2 is for T-Shirts/Jassen -->
                            <div class="border p-4 rounded-lg shadow-sm">
                                <img src="{{ asset('storage/' . $clothing->file_path) }}" alt="{{ $clothing->name }}" class="w-32 h-32 object-cover mx-auto mb-2">
                                <p class="text-center">{{ $clothing->name }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Broeken Section -->
                <div class="border p-4 rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold mb-4">Broeken</h2>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach ($clothings->where('category_id', 3) as $clothing) <!-- Assuming category_id 3 is for Broeken -->
                            <div class="border p-4 rounded-lg shadow-sm">
                                <img src="{{ asset('storage/' . $clothing->file_path) }}" alt="{{ $clothing->name }}" class="w-32 h-32 object-cover mx-auto mb-2">
                                <p class="text-center">{{ $clothing->name }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Schoenen Section -->
                <div class="border p-4 rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold mb-4">Schoenen</h2>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach ($clothings->where('category_id', 4) as $clothing) <!-- Assuming category_id 4 is for Schoenen -->
                            <div class="border p-4 rounded-lg shadow-sm">
                                <img src="{{ asset('storage/' . $clothing->file_path) }}" alt="{{ $clothing->name }}" class="w-32 h-32 object-cover mx-auto mb-2">
                                <p class="text-center">{{ $clothing->name }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

            <!-- Right side: Buttons for Randomize and Save -->
            <div class="flex flex-col space-y-6">
                <div>
                    <!-- Randomize Button -->
                    <button class="bg-blue-500 text-white py-3 px-6 rounded-md shadow-md w-full">Randomize</button>
                </div>
                <div>
                    <!-- Save Button -->
                    <button class="bg-green-500 text-white py-3 px-6 rounded-md shadow-md w-full">Save</button>
                </div>
            </div>

        </div>
    </div>
@endsection
