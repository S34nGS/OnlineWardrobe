@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <h2 class="text-2xl font-semibold mb-6">My Favorite Outfits</h2>

    @if($outfits->isEmpty())
        <p class="text-gray-500">You have no saved outfits.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($outfits as $outfit)
                <div class="border rounded-lg overflow-hidden">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold mb-4">{{ $outfit->name ?? 'Outfit' }}</h3>
                        <div class="grid grid-cols-2 gap-4">
                            @foreach($outfit->clothing_ids as $categoryId => $clothingId)
                                @php
                                    $clothing = \App\Models\Clothing::find($clothingId);
                                @endphp
                                @if($clothing)
                                    <div class="border rounded-lg overflow-hidden">
                                        <img src="{{ asset($clothing->file_path) }}" alt="{{ $clothing->name }}" class="w-full h-32 object-cover">
                                        <div class="p-2">
                                            <h4 class="text-sm font-semibold">{{ $clothing->name }}</h4>
                                            <p class="text-gray-600 text-xs">{{ $clothing->color }}</p>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <form action="{{ route('outfits.destroy', $outfit->id) }}" method="POST" class="mt-4">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Delete Outfit</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection