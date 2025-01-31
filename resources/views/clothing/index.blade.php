@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <!-- Outer wrapper for centering content -->
    <div class="flex justify-center">
        <div class="flex flex-col items-center w-full sm:w-4/5 lg:w-3/5">

            <!-- Loop through categories -->
            @foreach ($categories as $category)
                <div class="w-full text-center mb-10">
                    <h3 class="text-xl font-semibold mb-4">{{ $category->name }}</h3>

                    <!-- Clothing Selection Dropdown -->
                    <select class="border p-2 rounded mb-4 clothing-dropdown" data-category-id="{{ $category->id }}" 
                            onchange="changeClothing(this, '{{ $category->id }}')">
                        @foreach ($category->clothings as $clothing)
                            <option value="{{ $clothing->id }}" data-img="{{ asset('storage/' . $clothing->file_path) }}" 
                                    data-name="{{ $clothing->name }}" data-color="{{ $clothing->color }}">
                                {{ $clothing->name }} - {{ $clothing->color }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Displayed Clothing Item -->
                    <div class="bg-gray-100 p-4 rounded-lg shadow-md text-center w-3/4 mb-6" id="clothing-display-{{ $category->id }}">
                        @if ($category->clothings->count() > 0)
                            @php $firstClothing = $category->clothings->first(); @endphp
                            <img src="{{ asset('storage/' . $firstClothing->file_path) }}" class="w-48 h-auto mx-auto rounded-lg clothing-img">
                            <p class="mt-3 text-lg font-medium clothing-text">{{ $firstClothing->name }} - {{ $firstClothing->color }}</p>
                        @else
                            <p class="text-gray-500">No clothing available</p>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-4 flex flex-col gap-2">
                        <a href="{{ route('clothing.edit', $firstClothing ?? '') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Edit</a>
                        
                        <!-- Delete Button and Form -->
                        <form id="delete-form-{{ $category->id }}" action="{{ route('clothing.destroy', $firstClothing ?? '') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach

        </div>

        <!-- Sidebar with buttons -->
        <div class="flex flex-col gap-6 w-full sm:w-1/5 lg:w-1/5 mt-10 sm:mt-0">
            <a href="{{ route('clothing.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded text-center">Upload New Clothing</a>
            <button class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded">Randomize Outfits</button>
            <button class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-3 px-6 rounded">Save</button>
        </div>
    </div>
</div>

<script>
    function changeClothing(select, categoryId) {
        const selectedOption = select.options[select.selectedIndex];
        const clothingImage = selectedOption.getAttribute("data-img");
        const clothingName = selectedOption.getAttribute("data-name");
        const clothingColor = selectedOption.getAttribute("data-color");

        // Update the displayed clothing item
        const clothingDisplay = document.getElementById(`clothing-display-${categoryId}`);
        clothingDisplay.innerHTML = `
            <img src="${clothingImage}" class="w-48 h-auto mx-auto rounded-lg clothing-img">
            <p class="mt-3 text-lg font-medium clothing-text">${clothingName} - ${clothingColor}</p>
        `;

        // Dynamically update the delete form action
        const deleteForm = document.getElementById(`delete-form-${categoryId}`);
        deleteForm.action = `/clothes/${selectedOption.value}`;
    }

    // Function to fetch updated clothing list for each category
    function updateDropdowns() {
        document.querySelectorAll(".clothing-dropdown").forEach(dropdown => {
            const categoryId = dropdown.getAttribute("data-category-id");

            fetch(`/api/clothing/${categoryId}`)
                .then(response => response.json())
                .then(data => {
                    dropdown.innerHTML = "";
                    data.forEach(clothing => {
                        const option = document.createElement("option");
                        option.value = clothing.id;
                        option.setAttribute("data-img", clothing.image);
                        option.setAttribute("data-name", clothing.name);
                        option.setAttribute("data-color", clothing.color);
                        option.textContent = `${clothing.name} - ${clothing.color}`;
                        dropdown.appendChild(option);
                    });

                    // Automatically update the displayed clothing item
                    changeClothing(dropdown, categoryId);
                })
                .catch(error => console.error("Error updating dropdown:", error));
        });
    }

    // Auto-refresh every 5 seconds
    setInterval(updateDropdowns, 5000);
</script>
@endsection
