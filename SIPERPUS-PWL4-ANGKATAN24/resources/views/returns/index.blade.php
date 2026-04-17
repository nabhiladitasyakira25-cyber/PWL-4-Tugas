<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Return</h2>

    <form action="/returns/store" method="GET">
        <select name="loan_detail_id">
            @foreach($loanDetails as $ld)
                <option value="{{ $ld->id }}">
                    {{ $ld->book->title ?? '-' }}
                </option>
            @endforeach
        </select>

        <input name="charge" placeholder="denda">
        <button>Simpan</button>
    </form>

    <hr>

    @foreach($returns as $r)
        <p>{{ $r->loanDetail->book->title ?? '-' }} - {{ $r->charge }}</p>
    @endforeach
</body>
</html>