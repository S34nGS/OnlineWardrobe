@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Kledingkast</h1>
        
        <!-- Toon de kledingitems van de gebruiker -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($clothingItems as $item)
                <div class="border p-4 rounded-lg">
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-full h-64 object-cover mb-4">
                    <h2 class="text-xl font-semibold">{{ $item->name }}</h2>
                    <p>{{ $item->description }}</p>
                </div>
            @endforeach
        </div>
    </div>
@endsection
