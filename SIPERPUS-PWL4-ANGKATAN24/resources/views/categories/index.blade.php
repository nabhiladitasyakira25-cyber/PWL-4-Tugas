<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Category</h2>

    <form action="/categories" method="POST">
        @csrf
        <input name="category" placeholder="kategori">
        <button>Simpan</button>
    </form>

    <hr>

    @foreach($categories as $c)
        <p>{{ $c->category }}</p>
    @endforeach
</body>
</html>