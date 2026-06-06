<?php
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
 
use App\Models\User;
use App\Models\Book;
 
use Laravel\Sanctum\PersonalAccessToken;
 
class APIController extends Controller
{
    // LOGIN
    public function login(Request $req)
    {
        $user = User::where('email', $req->email)->first();
 
        if (!$user || !Hash::check($req->password, $user->password)) {
 
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
 
        $token = $user->createToken('token-name')->plainTextToken;
 
        return response()->json([
            'message' => 'success',
            'user' => $user,
            'token' => $token
        ], 200);
    }
 
    // LOGOUT
    public function logout(Request $req)
    {
        $accessToken = $req->bearerToken();
 
        $token = PersonalAccessToken::findToken($accessToken);
 
        $token->delete();
 
        return response()->json([
            'message' => 'user logged out'
        ], 200);
    }
 
    // GET ALL BOOKS
    public function books()
    {
        $books = Book::all();
 
        return response()->json([
            'message' => 'success',
            'books' => $books
        ], 200);
    }
 
    // STORE BOOK
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:150',
            'year' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'publisher' => 'required|max:100',
            'city' => 'required|max:75',
            'bookshelf_id' => 'required',
            'cover' => 'nullable|image',
        ]);
 
        if ($request->hasFile('cover')) {
 
            $path = $request->file('cover')->storeAs(
                'public/cover_buku',
                'cover_buku_' . time() . '.' . $request->file('cover')->extension()
            );
 
            $validated['cover'] = basename($path);
        }
 
        $book = Book::create($validated);
 
        return response()->json([
            'message' => 'buku berhasil ditambahkan',
            'book' => $book,
        ], 200);
    }
 
    // UPDATE BOOK
    public function update(Request $request, string $id)
    {
        $book = Book::find($id);
 
        if ($request->method() == 'PUT') {
 
            $validated = $request->validate([
                'title' => 'required|max:255',
                'author' => 'required|max:150',
                'year' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
                'publisher' => 'required|max:100',
                'city' => 'required|max:75',
                'bookshelf_id' => 'required',
                'cover' => 'nullable|image',
            ]);
 
        } else {
 
            $validated = $request->validate([
                'title' => 'sometimes|required|max:255',
                'author' => 'sometimes|required|max:150',
                'year' => 'sometimes|required|digits:4|integer|min:1900|max:' . date('Y'),
                'publisher' => 'sometimes|required|max:100',
                'city' => 'sometimes|required|max:75',
                'bookshelf_id' => 'sometimes|required',
                'cover' => 'nullable|image',
            ]);
        }
 
        if ($request->hasFile('cover')) {
 
            if ($book->cover != null) {
                Storage::delete('public/cover_buku/' . $book->cover);
            }
 
            $path = $request->file('cover')->storeAs(
                'public/cover_buku',
                'cover_buku_' . time() . '.' . $request->file('cover')->extension()
            );
 
            $validated['cover'] = basename($path);
        }
 
        Book::where('id', $id)
            ->update($validated);
 
        $res = Book::find($id);
 
        return response()->json([
            'message' => 'buku berhasil diubah',
            'book' => $res,
        ], 200);
    }
 
    // DELETE BOOK
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
 
        if ($book->cover != null) {
            Storage::delete('public/cover_buku/' . $book->cover);
        }
 
        $book->delete();
 
        return response()->json([
            'message' => 'buku berhasil dihapus',
        ], 200);
    }
}