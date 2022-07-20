<x-app-layout>
   
    <head>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css" integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ==" crossorigin="" />
        <link rel="stylesheet" href="{{asset('MarkerCluster.css')}}" />
        <link rel="stylesheet" href="{{asset('MarkerCluster.Default.css')}}" />
        <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js" integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ==" crossorigin=""></script>
        
        <script src="{{asset('leaflet_markercluster.js')}}"></script>
    </head>
    <style>
        #map {
            height: 92vh;
            width: 99vw;
            z-index: 1;
        }
        #map > div.leaflet-control-container > div.leaflet-bottom.leaflet-right > div > a > svg {
            display: none !important;
        }
        .leaflet-popup-content {
            width: 50vh !important;
            max-height: 50vh !important;
        }

        [x-cloak] { display: none !important; }
    </style>
    <body x-data={}>

        @livewire('livewire-header')
        
        <div id="map"></div>

        @livewire('upload-image-form')
        
        @livewire('create-tag-modal')

    </body>
</x-app-layout>

<script>

    var map = L.map('map').setView([51.505, -0.09], 8);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    let allImages = new L.markerClusterGroup();

    function loadMap() {
        fetch('/map/get-images').then(response => response.json()).then(data => {

            if (map.hasLayer(allImages)) {
                map.removeLayer(allImages);
                allImages.clearLayers();
            }

            data.forEach(element => {
                let tags = [];
                if (element.tags.length > 0) {
                        element.tags.forEach(tag => {
                        tags.push(tag.name);
                    });
                } else {
                    tags.push('no tags');
                }
                
                let taggedPeople = tags.join(', ');

                allImages.addLayer(L.marker([element.latitude, element.longitude]).bindPopup(`<div class="flex items-center justify-between mt-8"><h1 class="text-xl font-semibold mr-2">${element.title} </h1><button class="bg-sky-500 text-white active:bg-sky-600 font-bold uppercase text-xs px-2 py-1 m-0 rounded shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150" onclick="editImage(${element.id})" >edit</button></div><p>${element.description}</p><a href="/storage/${element.imagePath}"><img style="max-height: 35vh; margin: 0 auto" class="singleImage" src="{{ asset('/storage/${element.imagePath}')}}" /></a><br>tags: ${taggedPeople}`));
            });
           
            map.addLayer(allImages);

        }).catch(error => console.log(error));
    }
    
    editImage = (imageId) => { 
        Livewire.emit( "getSingleImage", imageId ); 
    };

    window.livewire.on('reload', () => {
        loadMap();
    });
    
    loadMap();

</script>