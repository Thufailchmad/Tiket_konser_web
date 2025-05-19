<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    {{-- Tambahkan CDN Bootstrap di atas jika belum ada di layout utama --}}
    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-event {
            border-radius: 15px;
            overflow: hidden;
            transition: 0.3s;
            height: 100%;
        }

        .card-event:hover {
            transform: scale(1.02);
        }

        .event-date {
            position: absolute;
            top: 10px;
            left: 10px;
            background: white;
            color: black;
            padding: 5px 10px;
            border-radius: 8px;
            font-weight: bold;
            text-align: center;
        }

        .nav-link {
            color: white !important;
        }

        .search-box {
            width: 300px;
        }
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @endpush
        
    <div class="py-4" style="background-color: #f8f9fc;">
        <!-- Filter Section -->
        <div class="container mt-4">
            <div class="d-flex justify-content-between align-items-center">
                <h3>Upcoming Events</h3>
                <div class="d-flex gap-2">
                    <select class="form-select">
                        <option selected>Weekdays</option>
                    </select>
                    <select class="form-select">
                        <option selected>Event Type</option>
                    </select>
                    <select class="form-select">
                        <option selected>Any Category</option>
                    </select>
                </div>
            </div>

            <!-- Event Cards -->
            <div class="row row-cols-1 row-cols-md-3 g-4 mt-2">
                @forelse ($tickets_list as $ticket)
                <div class="col">
                    <div class="card card-event h-100 shadow-sm position-relative">
                        <img src="{{ asset($ticket->images) }}" class="card-img-top" alt="{{ $ticket->name }}"
                            style="height: 180px; object-fit: cover;">
                        <div class="event-date">
                            {{ \Carbon\Carbon::parse($ticket->expired)->format('M') }}<br>
                            {{ \Carbon\Carbon::parse($ticket->expired)->format('d') }}
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $ticket->name }}</h5>
                            <p class="card-text text-muted" style="font-size: 0.9rem;">
                                {{ \Illuminate\Support\Str::limit($ticket->description, 60) }}
                            </p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center">
                    <p>Tidak ada tiket tersedia saat ini.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
