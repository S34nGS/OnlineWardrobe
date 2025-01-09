@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Petten / Hoeden Category -->
            <div id="category1">
                <h2 class="text-2xl font-semibold mb-4">Petten / Hoeden</h2>
                <div class="grid grid-cols-2 gap-4">
                    @foreach ($clothings as $clothing)
                        @if($clothing->category->name == 'Petten/Hoeden')
                            <div class="border p-4">
                                <img src="{{ $clothing->file_path }}" alt="{{ $clothing->name }}" class="w-full">
                                <h3 class="text-lg font-semibold mt-2">{{ $clothing->name }}</h3>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- T-shirts / Jassen Category -->
            <div id="category2">
                <h2 class="text-2xl font-semibold mb-4">T-shirts / Jassen</h2>
                <div class="grid grid-cols-2 gap-4">
                    @foreach ($clothings as $clothing)
                        @if($clothing->category->name == 'T-shirts/Jassen')
                            <div class="border p-4">
                                <img src="{{ $clothing->file_path }}" alt="{{ $clothing->name }}" class="w-full">
                                <h3 class="text-lg font-semibold mt-2">{{ $clothing->name }}</h3>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Broeken Category -->
            <div id="category3">
                <h2 class="text-2xl font-semibold mb-4">Broeken</h2>
                <div class="grid grid-cols-2 gap-4">
                    @foreach ($clothings as $clothing)
                        @if($clothing->category->name == 'Broeken')
                            <div class="border p-4">
                                <img src="{{ $clothing->file_path }}" alt="{{ $clothing->name }}" class="w-full">
                                <h3 class="text-lg font-semibold mt-2">{{ $clothing->name }}</h3>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Schoenen Category -->
            <div id="category4">
                <h2 class="text-2xl font-semibold mb-4">Schoenen</h2>
                <div class="grid grid-cols-2 gap-4">
                    @foreach ($clothings as $clothing)
                        @if($clothing->category->name == 'Schoenen')
                            <div class="border p-4">
                                <img src="{{ $clothing->file_path }}" alt="{{ $clothing->name }}" class="w-full">
                                <h3 class="text-lg font-semibold mt-2">{{ $clothing->name }}</h3>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Randomize and Save Buttons -->
        <div class="mt-8 flex justify-between">
            <button id="randomize" class="bg-blue-500 text-white py-2 px-4 rounded">Randomize</button>
            <button id="save" class="bg-green-500 text-white py-2 px-4 rounded">Save</button>
        </div>
    </div>

    <script>
        // Randomize Button Logic
        document.getElementById('randomize').addEventListener('click', function () {
            fetch('/randomize-clothes')
                .then(response => response.json())
                .then(data => {
                    // Update the UI with randomized clothes
                    console.log(data);
                    // Example of how you might update the page
                    // For now, just log the randomized clothes.
                });
        });

        // Save Button Logic
        document.getElementById('save').addEventListener('click', function () {
            const selectedClothes = [/* Array of selected/randomized clothing item IDs */];
            
            fetch('/save-randomized-clothes', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    clothing_ids: selectedClothes
                })
            })
            .then(response => response.json())
            .then(data => {
                alert('Clothes saved successfully!');
            });
        });
    </script>
@endsection
