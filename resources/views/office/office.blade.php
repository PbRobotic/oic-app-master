@extends('layout.app')

@section('title', 'Office')
@push('style')
    <style>
        .float-end {
            float: right;
        }
    </style>
@endpush
@section('main')
    <div class="content-viewport">
        <div class="row">
            <div class="col-lg-12">
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible alert-has-icon show fade">
                        <div class="alert-icon"><i class="far fa-circle-check"></i></div>
                        <div class="alert-body">
                            <div class="alert-title">Sukses</div>
                            <button class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                            {{ session('success') }}!
                        </div>
                    </div>
                @endif
                <div class="grid">
                    <div class="grid-header">
                        <p class="d-inline start">Office</p>
                        @if (auth()->user()->roles == 'ADMIN' || auth()->user()->roles == 'DIREKTUR')
                            <a href="{{ route('office.create') }}">
                                <button type="button" class="d-inline btn btn-outline-success mb-3 float-end">
                                    Add Document
                                </button>
                            </a>
                        @endif
                        @if (auth()->user()->roles !== 'ADMIN')
                            <a href="{{ route('office.print') }}">
                                <button type="button" class="d-inline btn btn-outline-success mb-3 mr-2 float-end">
                                    Print
                                </button>
                            </a>
                        @endif
                    </div>
                    <div class="item-wrapper">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Pembelian</th>
                                        <th>Nama</th>
                                        <th>Inventory Card</th>
                                        <th>Project</th>
                                        <th>Harga</th>
                                        <th>Jumlah (Satuan)</th>
                                        <th>Total</th>
                                        <th>Nilai Residu</th>
                                        <th>Nilai Penyusutan <br /> (Tahun Ke)</th>
                                        <th>Lokasi</th>
                                        <th>Kondisi</th>
                                        <th>Tanggal Peminjaman</th>
                                        <th>Pemakai</th>
                                        <th>Deskripsi</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @foreach ($offices as $item)
                                        <tr>
                                            <td>{{ $offices->firstItem() + $loop->index }}</td>
                                            <td>{{ $item->buy_date?->isoFormat('dddd, D MMMM Y') ?? '-' }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->inventory_card ?? '-' }}</td>
                                            <td>{{ $item->projects->name }}</td>
                                            <td>{{ Helper::formatRupiah($item->price) }}</td>
                                            <td>{{ $item->amount . " {$item->unit}" }}</td>
                                            <td>{{ Helper::formatRupiah($item->total) }}</td>
                                            <td>{{ Helper::formatRupiah($item->residu_value) }}</td>
                                            <td>{{ Helper::formatRupiah($item->depreciation_value) }}</td>
                                            <td>{{ $item->location }}</td>
                                            <td>
                                                @if ($item->condition == 'Baik')
                                                    <label class="badge badge-success">{{ $item->condition }}</label>
                                                @elseif($item->condition == 'Rusak')
                                                    <label class="badge badge-danger">{{ $item->condition }}</label>
                                                @else
                                                    <label class="badge badge-info">{{ $item->condition }}</label>
                                                @endif
                                            </td>
                                            <td>{{ $item->loan_date?->isoFormat('dddd, D MMMM Y') ?? '-' }}</td>
                                            <td>{{ $item->user ?? '-' }}</td>
                                            <td>{{ $item->description ?? '-' }}</td>
                                            <td>
                                                @if ($item->status == 1)
                                                    <label class="badge badge-success">Approve</label>
                                                @else
                                                    <label class="badge badge-danger">Pengajuan</label>
                                                @endif
                                            </td>
                                            @if (auth()->user()->roles == 'ADMIN' || auth()->user()->roles == 'DIREKTUR')
                                                <td>
                                                    <a href="{{ route('office.edit', $item->id) }}">
                                                        <button class="btn btn-primary btn-xs has-icon"><i
                                                                class="mdi mdi-pencil mr-0"></i></button>
                                                    </a>
                                                    <form method="POST" action="{{ route('office.destroy', $item->id) }}"
                                                        class="d-inline">
                                                        @csrf
                                                        {{ method_field('delete') }}
                                                        <button type="submit" class="btn btn-danger btn-xs has-icon"><i
                                                                class="mdi mdi-delete mr-0"></i></button>
                                                    </form>
                                                    @if (auth()->user()->roles == 'DIREKTUR')
                                                        <form method="POST"
                                                            action="{{ route('office.status', $item->id) }}"
                                                            class="d-inline">
                                                            @csrf
                                                            {{ method_field('put') }}
                                                            <button type="submit"
                                                                class="btn btn-warning btn-xs has-icon"><i
                                                                    class="mdi mdi-check mr-0"></i></button>
                                                        </form>
                                                </td>
                                            @endif
                                            </td>
                                    @endif

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="float-end">
                    {!! $offices->links() !!}
                </div>
            </div>
            <!-- content viewport ends -->
            <!-- partial:../../partials/_footer.html -->
            <!-- content viewport ends -->
            <!-- partial:partials/_footer.html -->
            @include('component.footer')
            <!-- partial -->
        </div>
        <!-- page content ends -->
    </div>
@endsection
