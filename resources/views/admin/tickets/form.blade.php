@extends('admin.layout.app')
@section('title', 'Form Tiket')
@section('content')
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Form Tiket</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="#">Manajemen Tiket</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('tickets.index') }}">Tiket</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Form</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Page content -->
    <div class="container-fluid mt--6">
        <div class="row justify-content-center">
            <div class="col col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ isset($ticket) ? route('tickets.update', $ticket->id) : route('tickets.store') }}" enctype="multipart/form-data">
                            @csrf
                            @if (isset($ticket))
                                @method('PATCH')
                            @endif

                            <div class="form-group row">
                                <label class="col-md-2 col-form-label form-control-label">Nama</label>
                                <div class="col-md-10">
                                    <input type="text" name="name" class="form-control" value="{{ $ticket->name ?? old('name') }}" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2 col-form-label form-control-label">Harga</label>
                                <div class="col-md-10">
                                    <input type="number" name="price" class="form-control" value="{{ $ticket->price ?? old('price') }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2 col-form-label form-control-label">Expired</label>
                                <div class="col-md-10">
                                    <input type="date" name="expired" class="form-control" value="{{ isset($ticket->expired) ? \Carbon\Carbon::parse($ticket->expired)->format('Y-m-d') : old('expired') }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2 col-form-label form-control-label">Lokasi</label>
                                <div class="col-md-10">
                                    <input type="text" name="lokasi" class="form-control" value="{{ isset($ticket->lokasi) ? \Carbon\Carbon::parse($ticket->expired)->format('Y-m-d') : old('expired') }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2 col-form-label form-control-label">Deskripsi</label>
                                <div class="col-md-10">
                                    <textarea name="description" class="form-control" rows="3">{{ $ticket->description ?? old('description') }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2 col-form-label form-control-label">Gambar</label>
                                <div class="col-md-10">
                                    <input type="file" name="images" class="form-control">
                                    @if(isset($ticket) && $ticket->images)
                                        <img src="{{ asset($ticket->images) }}" alt="Gambar Tiket" width="120" class="mt-2">
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <a href="{{ route('tickets.index') }}" class="btn btn-secondary">Batal</a>
                                    <button type="submit" class="btn btn-success">
                                        {{ isset($ticket) ? 'Update' : 'Simpan' }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
