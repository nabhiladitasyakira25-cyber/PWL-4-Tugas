<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Book</h2>

    <form action="/books" method="POST">
        @csrf
        <input name="title" placeholder="judul">

        <select name="category_id">
            @foreach($categories as $c)
                <option value="{{ $c->id }}">{{ $c->category }}</option>
            @endforeach
        </select>

        <button>Simpan</button>
    </form>

    <hr>

    @foreach($books as $b)
        <p>{{ $b->title }} - {{ $b->category->category ?? '-' }}</p>
    @endforeach
</body>
</html>