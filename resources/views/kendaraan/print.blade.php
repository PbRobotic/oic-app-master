<!DOCTYPE html>
<html>

<head>
    <title>Data Kendaraan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        h1 {
            font-size: 2em;
            /* 40px/16=2.5em */
        }

        h2 {
            font-size: 1.875em;
            /* 30px/16=1.875em */
        }

        th,
        td,
        p {
            font-size: 0.575em;
            /* 14px/16=0.875em */
        }
    </style>
</head>

<body>
    <h1>Kendaraan</h1>
    <p>Tanggal Print : {{ now() }}</p>

    <table class="table table-bordered table-striped">
        <thead class="text-center">
            <tr>
                <th>No</th>
                <th>Tanggal Pembelian</th>
                <th>Nama</th>
                <th>Inventory Card</th>
                <th>Project</th>
                <th>Harga</th>
                <th>Nilai Residu</th>
                <th>Nilai Penyusutan <br /> (Tahun Ke)</th>
                <th>Lokasi</th>
                <th>Kondisi</th>
                <th>Tanggal Peminjaman</th>
                <th>Pemakai</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($kendaraans as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->buy_date?->isoFormat('dddd, D MMMM Y') ?? '-' }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->inventory_card ?? '-' }}</td>
                    <td>{{ $item->projects->name }}</td>
                    <td>{{ Helper::formatRupiah($item->price) }}</td>
                    <td>{{ Helper::formatRupiah($item->residu_value) }}</td>
                    <td>
                        @for ($i = 1; $i <= 10; $i++)
                            <li>Ke-{{ $i }}
                                {{ Helper::formatRupiah(($item->price - $item->residu_value) / $i) }}
                            </li>
                        @endfor
                    </td>
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
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
