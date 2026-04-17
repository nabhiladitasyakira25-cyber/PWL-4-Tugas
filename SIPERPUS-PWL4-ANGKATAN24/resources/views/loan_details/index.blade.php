<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Loan Detail</h2>

    <form action="/loan-details/store" method="GET">
        <select name="loan_id">
            @foreach($loans as $l)
                <option value="{{ $l->id }}">{{ $l->id }}</option>
            @endforeach
        </select>

        <select name="book_id">
            @foreach($books as $b)
                <option value="{{ $b->id }}">{{ $b->title }}</option>
            @endforeach
        </select>

        <button>Simpan</button>
    </form>

    <hr>

    @foreach($loanDetails as $ld)
        <p>{{ $ld->book->title ?? '-' }}</p>
    @endforeach
</body>
</html>