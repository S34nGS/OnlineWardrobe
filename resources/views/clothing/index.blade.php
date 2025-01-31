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
                            <option value="{{ $clothing->id }}" data-img="{{ asset($clothing->file_path) }}" 
                                    data-name="{{ $clothing->name }}" data-color="{{ $clothing->color }}">
                                {{ $clothing->name }} - {{ $clothing->color }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Displayed Clothing Item -->
                    <div class="bg-gray-100 p-4 rounded-lg shadow-md text-center w-3/4 mb-6 flex items-center" id="clothing-display-{{ $category->id }}">
                        @if ($category->clothings->count() > 0)
                            @php $firstClothing = $category->clothings->first(); @endphp
                            <div class="flex-shrink-0">
                                <img src="{{ asset($firstClothing->file_path) }}" class="w-48 h-auto mx-auto rounded-lg clothing-img">
                            </div>
                            <div class="ml-4">
                                <p class="mt-3 text-lg font-medium clothing-text">{{ $firstClothing->name }} - {{ $firstClothing->color }}</p>
                            </div>
                            <div class="ml-auto flex flex-col gap-2">
                                <a href="{{ route('clothing.edit', $firstClothing ?? '') }}" class="text-blue-500 hover:text-blue-600 edit-button">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form id="delete-form-{{ $category->id }}" action="{{ route('clothing.destroy', $firstClothing ?? '') }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-600">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        @else
                            <p class="text-gray-500">No clothing available</p>
                        @endif
                    </div>
                </div>
            @endforeach

        </div>

        <!-- Sidebar with buttons -->
        <div class="flex flex-col gap-6 w-full sm:w-1/5 lg:w-1/5 mt-10 sm:mt-0">
            <a href="{{ route('clothing.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded text-center">Upload New Clothing</a>
            <button class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded" onclick="randomizeOutfits()">Randomize Outfits</button>
            <button class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-3 px-6 rounded">Save</button>
        </div>
    </div>
</div>

<script>
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

    // Function to change clothing display
    function changeClothing(select, categoryId) {
        const selectedOption = select.options[select.selectedIndex];
        const clothingImage = selectedOption.getAttribute("data-img");
        const clothingName = selectedOption.getAttribute("data-name");
        const clothingColor = selectedOption.getAttribute("data-color");
        const clothingId = selectedOption.value;

        // Update the image
        const imageElement = document.querySelector(`#clothing-display-${categoryId} .clothing-img`);
        imageElement.src = clothingImage;

        // Update the text
        const textElement = document.querySelector(`#clothing-display-${categoryId} .clothing-text`);
        textElement.textContent = `${clothingName} - ${clothingColor}`;

        // Update the edit button link
        const editButton = document.querySelector(`#clothing-display-${categoryId} .edit-button`);
        editButton.href = `/clothing/${clothingId}/edit`;

        // Update the delete form action
        const deleteForm = document.querySelector(`#clothing-display-${categoryId} .delete-form`);
        deleteForm.action = `/clothing/${clothingId}`;
    }

    // Function to randomize outfits
    function randomizeOutfits() {
        document.querySelectorAll(".clothing-dropdown").forEach(dropdown => {
            const options = dropdown.options;
            if (options.length > 0) {
                const randomIndex = Math.floor(Math.random() * options.length);
                dropdown.selectedIndex = randomIndex;
                const categoryId = dropdown.getAttribute("data-category-id");
                changeClothing(dropdown, categoryId);
            }
        });
    }
</script>
@endsection