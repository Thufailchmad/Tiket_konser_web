<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Tiketin Aja</title>
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
</head>

<body style="background-color: #f8f9fc;">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg" style="background-color: #0039a6;">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('assets/img/brand/logo-tiket.png') }}" alt="Tiketin Aja Logo" height="60">
            </a>
            <form class="d-flex search-box" role="search">
                <input class="form-control me-2" type="search" placeholder="Cari Tiket" aria-label="Search">
            </form>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 gap-3">
                <li class="nav-item"><a class="nav-link" href="#">Biaya</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Event</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Hubungi Kami</a></li>
                <li class="nav-item">
                    <a class="btn btn-primary" href="/login">Login</a>
                </li>
            </ul>
        </div>
    </nav>

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
                    <img src="{{ url($ticket->images) }}" class="card-img-top" alt="{{ $ticket->name }}" style="height: 180px; object-fit: cover;">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>