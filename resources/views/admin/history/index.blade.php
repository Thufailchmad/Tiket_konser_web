@extends('admin.layout.app')
@section('title', 'Admin - Tiket')
@section('content')
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Data Payment</h6>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#">Payment</a></li>
                            <!-- <li class="breadcrumb-item active" aria-current="page">Tiket</li> -->
                        </ol>
                    </nav>
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
                                <th>Id</th>
                                <th>total</th>
                                <th>Gambar</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($histories as $history)
                            <tr>
                                <td>{{ $history->user->name }}</td>
                                <td>{{ $history->id }}</td>
                                <td>Rp {{ number_format($history->total, 0, ',', '.') }}</td>
                                <td>
                                    <img src="{{ asset($history->image) }}" alt="Gambar Tiket" width="80">
                                </td>
                                <td class="table-actions">
                                    @if ($history->status == 0)
                                    <form action="{{ route('history.reqPayment', $history->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="_method" value="PUT">
                                        <input type="number" name="status" hidden value="1">
                                        <button type="submit"
                                            class="table-action table-action-delete btn btn-link p-0"
                                            data-toggle="tooltip" data-original-title="Accept">
                                            <i class="fas fa-check text-green"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('history.reqPayment', $history->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="_method" value="PUT">
                                        <input type="number" name="status" hidden value="2">
                                        <button type="submit"
                                            class="table-action table-action-delete btn btn-link p-0"
                                            data-toggle="tooltip" data-original-title="Decline">
                                            <i class="fas fa-times text-danger"></i>
                                        </button>
                                    </form>
                                    @elseif($history->status == 1)
                                    Diterima
                                    @elseif($history->status == 2)
                                    Ditolak
                                    @endif

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