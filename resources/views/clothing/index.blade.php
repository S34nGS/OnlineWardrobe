@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <!-- Outer wrapper for centering content -->
    <div class="flex justify-center">
        <div class="flex flex-col items-center w-full sm:w-4/5 lg:w-3/5 mr-10"> <!-- Added margin-right -->
            <!-- Loop through categories -->
            @foreach ($categories as $category)
                <div class="w-full flex mb-10">
                    <div class="w-1/4 text-left">
                        <h3 class="text-xl font-semibold mb-4">{{ $category->name }}</h3>
                        <!-- Clothing Selection Dropdown -->
                        <select class="border p-2 rounded mb-4 clothing-dropdown pr-10" data-category-id="{{ $category->id }}" 
                                onchange="changeClothing(this, '{{ $category->id }}')">
                            @foreach ($category->clothings as $clothing)
                                <option value="{{ $clothing->id }}" data-img="{{ asset($clothing->file_path) }}" 
                                        data-name="{{ $clothing->name }}" data-color="{{ $clothing->color }}">
                                    {{ $clothing->name }} - {{ $clothing->color }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-3/4 text-center">
                        <!-- Displayed Clothing Item -->
                        <div class="bg-gray-100 p-4 rounded-lg shadow-md text-center w-full mb-6 flex flex-col items-center" id="clothing-display-{{ $category->id }}">
                            @if ($category->clothings->count() > 0)
                                @php $firstClothing = $category->clothings->first(); @endphp
                                <div class="flex-shrink-0 mb-4">
                                    <img src="{{ asset($firstClothing->file_path) }}" class="w-48 h-auto mx-auto rounded-lg clothing-img">
                                </div>
                                <div class="text-center">
                                    <p class="mt-3 text-lg font-medium clothing-text">{{ $firstClothing->name }} - {{ $firstClothing->color }}</p>
                                </div>
                                <div class="mt-4 flex gap-2">
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
                </div>
            @endforeach

        </div>

        <!-- Sidebar with buttons -->
        <div class="flex flex-col gap-6 w-full sm:w-1/5 lg:w-1/5 mt-10 sm:mt-0">
            <a href="{{ route('clothing.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-4 rounded-lg text-center flex flex-col items-center w-40">
                <i class="fas fa-plus fa-2x"></i>
                <span class="text-sm">Upload New Clothing</span>
            </a>
            <button class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-4 rounded-lg flex flex-col items-center w-40" onclick="randomizeOutfits()">
                <i class="fas fa-random fa-2x"></i>
                <span class="text-sm">Randomize Outfits</span>
            </button>
            <form action="{{ route('outfits.store') }}" method="POST">
                @csrf
                <input type="hidden" name="clothing_ids" id="clothing-ids">
                <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-3 px-4 rounded-lg w-40 flex flex-col items-center">
                    <i class="fas fa-heart fa-2x"></i>
                    <span class="text-sm">Save to favorites</span>
                </button>
            </form>
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

    // Function to save outfit
    function saveOutfit() {
        const clothingIds = {};
        document.querySelectorAll(".clothing-dropdown").forEach(dropdown => {
            const categoryId = dropdown.getAttribute("data-category-id");
            clothingIds[categoryId] = dropdown.value;
        });
        document.getElementById('clothing-ids').value = JSON.stringify(clothingIds);
    }

    document.querySelector('form[action="{{ route('outfits.store') }}"]').addEventListener('submit', saveOutfit);
</script>
@endsection