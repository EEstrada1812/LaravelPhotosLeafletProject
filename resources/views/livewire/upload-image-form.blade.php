{{-- ------------------ --}}
{{-- image upload modal --}}
{{-- ------------------ --}}
<div>
   
    <x-modal wire:model="show">

        <div class="flex justify-between mb-4">
            <h3 class="font-bold text-2xl">{{$modalHeaderText}}</h3>
            <button x-on:click="show=false">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div>
            <form wire:submit.prevent="uploadImage" action="map/upload-image" method="post" enctype="multipart/form-data">
                @csrf
                <input wire:model="imageId" type="hidden" name="imageId">

                <label class="block text-gray-700 text-sm font-bold mb-2" for="title">Title:</label>
                <input wire:model="title" class="@error('title')border border-red-500 @enderror shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name="title" id="title">
                
                <br>
                @error('title')
                    <p class="text-red-500 mt-1">{{ $message }}</p>
                @enderror
                <br>
                
                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">Description:</label>
                <input wire:model="description" class="@error('description')border border-red-500 @enderror shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name="description" id="description">
                
                <br>
                @error('description')
                    <p class="text-red-500 mt-1">{{ $message }}</p>
                @enderror
                <br>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="latitude">Latitude:</label>
                        <input wire:model="latitude" class="@error('latitude')border border-red-500 @enderror shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name="latitude" id="latitude">
                        @error('latitude')
                            <br><p class="text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="longitude">Longitude:</label>
                        <input wire:model="longitude" class="@error('longitude')border border-red-500 @enderror shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name="longitude" id="longitude">
                        @error('longitude')
                            <br><p class="text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <label class="block text-gray-700 text-sm font-bold mb-2" for="imageFile">Image:</label>
                <input wire:model="imageFile"class="@error('imageFile')border border-red-500 @enderror shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="file" name="imageFile" id="imageFile">
                
                <br>
                @error('imageFile')
                    <p class="text-red-500 mt-1">{{ $message }}</p>
                @enderror
                <br>
                
                @if ($imageId)
                    <div>
                        <p>Image contains the following tags (click to remove):</p>
                        <div 
                            x-data="{removeTag:false}" 
                            x-show.transition.opacity.out.duration.1500ms="removeTag"
                            x-init="@this.on('tagRemoved', () => {removeTag = true; setTimeout(() => {removeTag = false;}, 1000);})"
                            class="bg-green-100 border-l-4 border-green-500 text-green-700 w-full my-2" role="alert">
                            <p class="p-2 font-bold"> Tag was successfully removed</p>
                        </div>
                        @if ($singleImageTags)
                            @foreach ($singleImageTags as $selectedTag )
                                <button wire:click="removeTag('{{$selectedTag->id}}')" type="button" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded mr-2 my-2">{{$selectedTag->name}}</button>
                            @endforeach
                            <br>
                        @endif
                    <div>
                @endif
                
                <div class="flex items-center justify-between">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="tags">Select Tags:</label>

                    <button x-on:click="window.livewire.emitTo('create-tag-modal', 'show')" class="bg-sky-500 text-white active:bg-sky-600 font-bold uppercase text-xs px-2 py-1 m-0 rounded shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150" type="button">Add New Tag</button>

                </div>
                
                <select wire:model="tags" class="tags shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"  name="tags[]" multiple>
                    @foreach ($allTags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                    @endforeach
                </select>
                
                <br><br>


                <button class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out" type="submit">{{$submitButtonText}}</button>
                
                @if ($imageId)
                    <button wire:click="deleteImage('{{ $imageId}}')" class="inline-block px-6 py-2.5 bg-red-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out" type="button">Delete Image</button>
                @endif
                
            </form>
        </div>

     
    </x-modal>
    

</div>
