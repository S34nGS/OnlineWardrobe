@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-2xl font-semibold mb-6">{{ $clothing->name }}</h1>

        <p><strong>Color:</strong> {{ $clothing->color }}</p>
        <p><strong>Category:</strong> {{ $clothing->category->name }}</p>

        <div class="mt-4">
            <a href="{{ route('clothing.edit', $clothing->id) }}" class="bg-green-500 text-white py-2 px-4 rounded-md">Edit</a>
            <form action="{{ route('clothing.destroy', $clothing->id) }}" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded-md">Delete</button>
            </form>
        </div>
    </div>
@endsection
