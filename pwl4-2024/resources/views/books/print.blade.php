<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Laporan Data Buku</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #333;
            margin: 30px;
            font-size: 13px;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header h1 {
            margin: 0;
            font-size: 26px;
            color: #222;
        }

        .header p {
            margin-top: 6px;
            color: #666;
            font-size: 14px;
        }

        .line {
            width: 100%;
            border-top: 2px solid #444;
            margin-top: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        thead {
            background-color: #f2f2f2;
        }

        th {
            border: 1px solid #999;
            padding: 10px;
            text-align: center;
            font-size: 13px;
        }

        td {
            border: 1px solid #999;
            padding: 8px;
            vertical-align: middle;
        }

        tbody tr:nth-child(even) {
            background-color: #fafafa;
        }

        .text-center {
            text-align: center;
        }

        .cover-img {
            border-radius: 4px;
            border: 1px solid #ccc;
            padding: 2px;
        }

        .empty-image {
            color: #888;
            font-style: italic;
            font-size: 12px;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            color: #666;
            font-size: 12px;
        }

        @media print {
            body {
                margin: 15px;
            }

            .footer {
                position: fixed;
                bottom: 0;
                right: 0;
            }
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>Data Buku</h1>
        <p>Laporan Data Buku Tahun 2026</p>
        <div class="line"></div>
    </div>

    <table id="table-data">
        <thead>
            <tr>
                <th width="5%">NO</th>
                <th width="25%">JUDUL</th>
                <th width="20%">PENULIS</th>
                <th width="10%">TAHUN</th>
                <th width="20%">PENERBIT</th>
                <th width="20%">COVER</th>
            </tr>
        </thead>

        <tbody>
            @php $no=1; @endphp

            @foreach ($books as $book)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author }}</td>
                    <td class="text-center">{{ $book->year }}</td>
                    <td>{{ $book->publisher }}</td>
                    <td class="text-center">
                        @if ($book->cover !== null)
                            <img
                                src="{{ public_path('storage/cover_buku/' . $book->cover) }}"
                                width="75"
                                class="cover-img"
                            />
                        @else
                            <span class="empty-image">
                                Gambar tidak tersedia
                            </span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ date('d M Y') }}
    </div>

</body>

</html>