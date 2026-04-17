<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Loan</h2>

    <form action="/loans" method="POST">
        @csrf
        <select name="user_npm">
            @foreach($users as $u)
                <option value="{{ $u->npm }}">{{ $u->username }}</option>
            @endforeach
        </select>

        <button>Simpan</button>
    </form>

    <hr>

    @foreach($loans as $l)
        <p>{{ $l->user->username ?? '-' }}</p>
    @endforeach
</body>
</html>