{{-- ---------------- --}}
{{-- create tag modal --}}
{{-- ---------------- --}}
<div>
    <x-modal wire:model="show" x-on:close.window="show=false">
        
        <div class="flex justify-between mb-4">
            <h3 class="font-bold text-2xl">Create New Tag</h3>
            <button x-on:click="show=false">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div>
            <form wire:submit.prevent="createTag" action="map/create-tag" method="post" enctype="multipart/form-data">
                @csrf
                
                <label class="block text-gray-700 text-sm font-bold mb-2" for="createTag">Create New Tag:</label>
                <input wire:model="newTag" class="@error('createTag')border border-red-500 @enderror shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name="createTag" id="createTag">
                <br>
                
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <p class="text-red-500 mt-1">{{ $error }}</p>
                    @endforeach
                @endif
                
                <br>

                <button class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out" type="submit">Save New Tag</button>
            </form>
        </div>


    </x-modal>    
</div>
