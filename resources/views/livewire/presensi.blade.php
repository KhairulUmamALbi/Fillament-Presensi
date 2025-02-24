<div>
    <div class="container mx-auto max-w-sm">
        <div class="bg-white p-6 rounded-lg mt-3 shadow-lg">
            <div class="grid grid-cols-1 gap-6 mb-6">
                <div>
                    <h2 class="text-2xl font-bold mb-2">Informasi Pegawai</h2>
                    <div class="bg-gray-100 p-4 rounded-lg">
                        <p><strong>Nama Pegawai</strong> {{ Auth::user()->name }}</p>
                        <p><strong>Kantor</strong> {{ $schedules->offices->name }} </p>
                        <p><strong>Shift</strong> {{ $schedules->shifts->name }} ({{ $schedules->shifts->start_time }} -
                            {{ $schedules->shifts->end_time }})</p>
                        @if ($schedules->is_wfa)
                        <p class="text-green-500"><strong>Status : WFA </strong></p>
                        @else
                        <p><strong>Status : WFO </strong></p>
                        @endif
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-2">
                        <div class="bg-gray-100 p-1 rounded-lg">
                            <h4 class="text-l font-bold mb-2">Waktu Datang</h4>
                            <p><strong>{{ $attendances ? $attendances->start_time : '-'}}</strong></p>
                        </div>

                        <div class="bg-gray-100 p-1 rounded-lg">
                            <h4 class="text-l font-bold mb-2">Waktu Pulang</h4>
                            <p><strong>{{ $attendances ? $attendances->end_time : '-' }}</strong></p>
                        </div>

                    </div>
                </div>
                <div class="">
                    <h2 class="text-2xl font-bold mb-2">Presensi</h2>
                    <div id="map" class="mb-4 rounded-lg border border-gray-300" wire:ignore></div>
                    @if (session()->has('error'))
                    <div class="bg-red-500 text-white p-2 rounded-lg">
                        {{ session('error') }}
                    </div>
                    @endif
                    <form class="row g-3 mt-3" wire:submit='store' enctype="multipart/form-data">
                        <button type="button" onclick="tagLocation()"
                            class="px-4 py-2 bg-blue-500 text-white rounded">Tag
                            Location</button>
                        @if ($insideRadius)
                        <button type="submit" onclick="" class="px-4 py-2 bg-green-500 text-white rounded">Submit
                            Presensi</button>
                        @endif
                    </form>


                </div>

            </div>
        </div>
    </div>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        let map;
        let lat;
        let lng;
        const office = [{{ $schedules->offices->latitude }}, {{ $schedules->offices->longitude }}];
        const radius = [{{ $schedules->offices->radius }}]
        let component;
        let marker;
        document.addEventListener('livewire:initialized', function () {
            component = @this;
            map = L.map('map').setView([{{ $schedules->offices->latitude }}, {{ $schedules->offices->longitude }}], 20);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        //const personIcon = L.icon({
        //     iconUrl: 'path/to/person-icon.png', // Replace with the path to your person icon
        //     iconSize: [32, 32], // Size of the icon
        //     iconAnchor: [16, 32], // Point of the icon which will correspond to marker's location
        //     popupAnchor: [0, -32] // Point from which the popup should open relative to the iconAnchor
        // });

        L.circle(office, {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: radius
        }).addTo(map);

    });

        function tagLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    lat = position.coords.latitude;
                    lng = position.coords.longitude;

                    if (marker) {
                        map.removeLayer(marker);
                    }

                    marker = L.marker([lat, lng]).addTo(map);
                    // marker = L.marker([lat, lng], { icon: personIcon }).addTo(map);
                    map.setView([lat, lng], 20);

                    if (isWithRadius(lat, lng, office, radius)) {
                        component.set('insideRadius', true);
                        component.set('latitude', lat);
                        component.set('longitude', lng);
                        alert('You are in the radius');
                    }
                });
            } else {
                alert('Geolocation is not supported by this browser.');
            }
        }

        function isWithRadius(lat, lng, center, radius) {

            const is_wfa = {{ $schedules->is_wfa }};
            if (is_wfa) {
                return true;
            }else{
                let distance = map.distance([lat, lng], center);
                return distance <= radius;
            }

        }
    </script>
</div>