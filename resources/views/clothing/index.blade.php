@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-2xl font-semibold mb-6">Clothing Items</h1>

        <a href="{{ route('clothing.create') }}" class="bg-blue-500 text-white py-2 px-4 rounded-md mb-4">Add New Clothing</a>

        <table class="w-full border border-gray-300">
            <thead>
                <tr>
                    <th class="border-b p-2">Name</th>
                    <th class="border-b p-2">Color</th>
                    <th class="border-b p-2">Category</th>
                    <th class="border-b p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clothes as $clothing)
                    <tr>
                        <td class="border-b p-2">{{ $clothing->name }}</td>
                        <td class="border-b p-2">{{ $clothing->color }}</td>
                        <td class="border-b p-2">{{ $clothing->category->name }}</td>
                        <td class="border-b p-2">
                            <a href="{{ route('clothing.show', $clothing->id) }}" class="text-blue-500">View</a> |
                            <a href="{{ route('clothing.edit', $clothing->id) }}" class="text-green-500">Edit</a> |
                            <form action="{{ route('clothing.destroy', $clothing->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
