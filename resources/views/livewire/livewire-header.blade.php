{{-- ---------- --}}
{{-- Header Bar --}}
{{-- ---------- --}}
<div>
    <div class="px-4 py-2 flex justify-between items-center">
        <button wire:click="$emit('resetUploadForm')"
        class="inline-block px-6 py-2.5 bg-blue-600 text-white font-small text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out" 
        >Upload Image</button>
            
        {{-- <div 
            x-data="{success:false}" 
            x-show="success"
            x-init="@this.on('saved', () => {success = true; })"
            style="display: none" 
            class="bg-green-100 border-l-4 border-green-500 text-green-700 w-5/6" role="alert">
            <p class="p-2 font-bold"> Image was successfully updated</p>
        </div> --}}

        @if (session()->has('message'))
            <div  class="bg-green-100 border-l-4 border-green-500 text-green-700 w-5/6" role="alert">
                <p class="p-2 font-bold">{{ session('message') }}</p>
            </div>
        @endif
                
    </div>

</div>
