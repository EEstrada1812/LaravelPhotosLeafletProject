<div 
    x-data="{ show: @entangle($attributes->wire('model')) }" 
    x-show="show"
    x-cloak
    class="fixed inset-0 bg-white bg-opacity-75 flex items-center justify-center z-20" >
    <div x-show="show" x-cloak class="flex flex-col bg-white shadow-2xl rounded-lg border-2 border-gray-400 p-6 w-1/3">

        {{$slot}}

    </div>
</div> 