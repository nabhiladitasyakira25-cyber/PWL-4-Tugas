<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6 flex flex-wrap justify-between items-center gap-4">
                <div class="flex gap-2">
                    <x-primary-button tag="a" href="{{ route('book.create') }}">Tambah Data Buku</x-primary-button>
                    <x-primary-button tag="a" href="{{ route('book.print') }}" target='blank'>Cetak Buku</x-primary-button>
                </div>
            </div>

            <div class="mb-6 p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                <form action="{{ route('book') }}" method="GET" class="flex flex-col md:flex-row items-end gap-4">
                    
                    <div class="w-full md:w-1/2">
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cari Buku</label>
                        <input type="text" name="search" id="search" value="{{ $old_search }}" placeholder="Ketik judul atau nama penulis..." 
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div class="w-full md:w-1/3">
                        <label for="bookshelf_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter Berdasarkan Rak</label>
                        <select name="bookshelf_id" id="bookshelf_id" 
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">-- Semua Rak --</option>
                            @foreach($bookshelves as $shelf)
                                <option value="{{ $shelf->id }}" {{ $old_bookshelf == $shelf->id ? 'selected' : '' }}>
                                    {{ $shelf->code }} - {{ $shelf->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-2 w-full md:w-auto">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md shadow-sm transition">
                            Cari
                        </button>
                        @if(!empty($old_search) || !empty($old_bookshelf))
                            <a href="{{ route('book') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 text-sm font-medium rounded-md shadow-sm transition">
                                Reset
                            </a>
                        @endif
                    </div>

                </form>
            </div>

            <x-table>
                <x-slot name="header">
                    <tr>
                        <th>#</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Tahun</th>
                        <th>Penerbit</th>
                        <th>Kota</th>
                        <th>Cover</th>
                        <th>Kode Rak</th>
                        <th>Aksi</th>
                    </tr>
                </x-slot>

                @php $num=1; @endphp
                @forelse($books as $book)
                    <tr>
                        <td>{{ $num++ }}</td>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->year }}</td>
                        <td>{{ $book->publisher }}</td>
                        <td>{{ $book->city }}</td>
                        <td>
                            @if($book->cover)
                                <img src="{{ asset('storage/cover_buku/'.$book->cover) }}" width="100px" alt="Cover"/>
                            @else
                                <span class="text-gray-400">No image</span>
                            @endif
                        </td>
                        <td>{{ $book->bookshelf->code }}-{{ $book->bookshelf->name }}</td>
                        <td class="flex gap-2">
                            <x-primary-button tag="a" href="{{ route('book.edit', $book->id) }}">Edit</x-primary-button>
                            <form action="{{ route('book.delete', $book->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <x-danger-button onclick="return confirm('Yakin mau hapus data ini?')">
                                    Hapus
                                </x-danger-button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-8 text-gray-500 dark:text-gray-400">
                            Data buku tidak ditemukan.
                        </td>
                    </tr>
                @endforelse
            </x-table>
        </div>
    </div>
</x-app-layout>