<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Bookshelf</h2>

        <form action="/bookshelfs" method="POST">
            @csrf
            <input name="name" placeholder="nama rak">
            <button>Simpan</button>
        </form>

        <hr>

        @foreach($bookshelfs as $b)
            <p>{{ $b->name }}</p>
        @endforeach
</body>
</html>