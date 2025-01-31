@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-8">
        <h1 class="text-2xl font-semibold mb-6">Edit Clothing Item</h1>

        <form action="{{ route('clothing.update', $clothing) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <label class="block mb-2">Name:</label>
            <input type="text" name="name" value="{{ $clothing->name }}" required class="w-full border p-2 mb-4">

            <label class="block mb-2">Color:</label>
            <input type="text" name="color" value="{{ $clothing->color }}" required class="w-full border p-2 mb-4">

            <label class="block mb-2">Category:</label>
            <select name="category_id" class="w-full border p-2 mb-4">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $clothing->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <label class="block mb-2">Image:</label>
            <input type="file" name="image" class="w-full border p-2 mb-4">

            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
                Update Clothing
            </button>
        </form>
    </div>
@endsection
