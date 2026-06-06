<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Bookshelf;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 1. Ambil kata kunci search dan filter rak dari request browser
        $search = $request->get('search');
        $bookshelfId = $request->get('bookshelf_id');

        // 2. Buat query dasar mengambil data buku beserta relasi raknya
        $query = Book::with('bookshelf');

        // 3. Logic Search: Jika user mengetik judul atau nama penulis
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('author', 'like', '%' . $search . '%');
            });
        }

        // 4. Logic Filter: Jika user memilih kategori rak tertentu
        if (!empty($bookshelfId)) {
            $query->where('bookshelf_id', $bookshelfId);
        }

        // 5. Eksekusi query untuk mendapatkan list buku yang sudah disaring
        $data['books'] = $query->get();

        // 6. Ambil semua data rak untuk ditampilkan di dropdown filter halaman Blade
        $data['bookshelves'] = Bookshelf::all();

        // 7. Amankan input lama agar teks pencarian tidak hilang pasca-refresh halaman
        $data['old_search'] = $search;
        $data['old_bookshelf'] = $bookshelfId;

        return view('books.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['bookshelves'] = Bookshelf::pluck('name', 'id');
        return view('books.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:150',
            'year' => 'required|digits:4|integer|min:1900|max:'.(date('Y')),
            'publisher' => 'required|max:100',
            'city' => 'required|max:75',
            'bookshelf_id' => 'required',
            'cover' => 'nullable|image',
        ]);

        if($request->hasFile('cover')){
            $path = $request->file('cover')->storeAs(
                'cover_buku',
                'cover_buku_'.time() . '.' . $request->file('cover')->extension(),
                'public'
            );
            $validated['cover'] = basename($path);
        }

        Book::create($validated);

        $notification = array(
            'message' => "Data buku berhasil ditambahkan!",
            'alert-type' => 'success'
        );

        if($request->save == true){
            return redirect()->route('book')->with($notification);
        }else{
            return redirect()->route('book.create')->with($notification);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['book'] = Book::find($id);
        $data['bookshelves'] = Bookshelf::pluck('name', 'id');

        return view('books.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:150',
            'year' => 'required|digits:4|integer|min:1900|max:'.(date('Y')),
            'publisher' => 'required|max:100',
            'city' => 'required|max:75',
            'bookshelf_id' => 'required',
            'cover' => 'nullable|image',
        ]);

        if($request->hasFile('cover')){
            $path = $request->file('cover')->storeAs(
                'cover_buku',
                'cover_buku_'.time() . '.' . $request->file('cover')->extension(),
                'public'
            );
            $validated['cover'] = basename($path);
        }

        Book::where('id', $id)->update($validated);

        $notification = array(
            'message' => "Data buku berhasil ditambahkan!",
            'alert-type' => 'success'
        );

        if($request->save == true){
            return redirect()->route('book')->with($notification);
        }else{
            return redirect()->route('book.create')->with($notification);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return redirect()->route('book');
    }

    public function print()
    {
        $books = Book::all();
        $pdf = Pdf::loadView('books.print', ['books' => $books] );
        return $pdf->download('data_buku.pdf');
    }
}