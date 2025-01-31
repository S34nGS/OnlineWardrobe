@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-8">
        <h1 class="text-2xl font-semibold mb-6">Clothing Items in {{ $category->name }}</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($clothings as $clothing)
                <div class="border rounded-lg p-4">
                    <img src="{{ asset('storage/' . $clothing->file_path) }}" alt="{{ $clothing->name }}" class="w-full h-48 object-cover rounded-md mb-4">
                    <h3 class="text-lg font-semibold">{{ $clothing->name }}</h3>
                    <p class="text-gray-600">Color: {{ $clothing->color }}</p>

                    <!-- Action buttons -->
                    <div class="mt-4">
                        <form action="{{ route('clothing.edit', $clothing) }}" method="GET" class="inline-block">
                            <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600">Edit</button>
                        </form>

                        <form action="{{ route('clothing.destroy', $clothing) }}" method="POST" class="inline-block ml-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Paginatieknoppen -->
        <div class="mt-4">
            {{ $clothings->links() }}
        </div>
    </div>
@endsection
