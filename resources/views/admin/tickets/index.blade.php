@extends('admin.layout.app')
@section('title', 'Admin - Tiket')
@section('content')
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Data Tiket</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="#">Manajemen Tiket</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Tiket</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                        <a href="{{ route('tickets.create') }}" class="btn btn-sm btn-neutral">Tambah</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Page content -->
    <div class="container-fluid mt--6">
        <!-- Table -->
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="table-responsive py-4 px-3">
                        <table class="table table-flush" id="datatable-basic">
                            <thead class="thead-light">
                                <tr>
                                    <th>Nama</th>
                                    <th>Harga</th>
                                    <th>Expired</th>
                                    <th>Deskripsi</th>
                                    <th>Gambar</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tickets_list as $ticket)
                                    <tr>
                                        <td>{{ $ticket->name }}</td>
                                        <td>Rp {{ number_format($ticket->price, 0, ',', '.') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($ticket->expired)->format('d-m-Y') }}</td>
                                        <td>{{ $ticket->description }}</td>
                                        <td>
                                            <img src="{{ asset($ticket->images) }}" alt="Gambar Tiket" width="80">
                                        </td>
                                        <td class="table-actions">
                                            <a href="{{ route('tickets.edit', $ticket->id) }}" class="table-action" data-toggle="tooltip" data-original-title="Edit">
                                                <i class="fas fa-user-edit"></i>
                                            </a>
                                            <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="table-action table-action-delete btn btn-link p-0"
                                                    onclick="return confirm('Apakah anda yakin ingin menghapus tiket ini?')"
                                                    data-toggle="tooltip" data-original-title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
