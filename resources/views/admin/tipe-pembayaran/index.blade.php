<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manajemen Tipe Pembayaran
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Alert Success -->
                    @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r" role="alert">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="font-medium">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    <!-- Header & Tombol Tambah -->
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">Daftar Tipe Pembayaran</h3>
                            <p class="text-sm text-gray-600 mt-1">Kelola semua tipe pembayaran yang tersedia</p>
                        </div>
                        <a href="{{ route('admin.tipe-pembayaran.create') }}" 
                           class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg flex items-center gap-2 transition duration-300 shadow-md hover:shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span class="font-semibold">Tambah Tipe Pembayaran</span>
                        </a>
                    </div>

                    <!-- Tabel -->
                    <div class="overflow-x-auto bg-white rounded-lg shadow">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-blue-500 to-blue-600">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        No
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Nama Tipe Pembayaran
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Deskripsi
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($tipePembayarans as $index => $tipe)
                                    <tr class="hover:bg-gray-50 transition duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $tipePembayarans->firstItem() + $index }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                                    </svg>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-semibold text-gray-900">{{ $tipe->nama }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            {{ $tipe->deskripsi ? Str::limit($tipe->deskripsi, 50) : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($tipe->is_active)
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Aktif
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Nonaktif
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex justify-center gap-2">
                                                <!-- Detail Button -->
                                                <a href="{{ route('admin.tipe-pembayaran.show', $tipe) }}" 
                                                   class="bg-cyan-500 hover:bg-cyan-600 text-white px-3 py-2 rounded-md transition duration-300 flex items-center gap-1 shadow-sm hover:shadow-md"
                                                   title="Detail">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                    <span class="hidden sm:inline">Detail</span>
                                                </a>

                                                <!-- Edit Button -->
                                                <a href="{{ route('admin.tipe-pembayaran.edit', $tipe) }}" 
                                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-md transition duration-300 flex items-center gap-1 shadow-sm hover:shadow-md"
                                                   title="Edit">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                    <span class="hidden sm:inline">Edit</span>
                                                </a>

                                                <!-- Delete Button -->
                                                <form action="{{ route('admin.tipe-pembayaran.destroy', $tipe) }}" 
                                                      method="POST" 
                                                      onsubmit="return confirm('Yakin ingin menghapus tipe pembayaran {{ $tipe->nama }}?')"
                                                      class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-md transition duration-300 flex items-center gap-1 shadow-sm hover:shadow-md"
                                                            title="Hapus">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                        <span class="hidden sm:inline">Hapus</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                                </svg>
                                                <p class="text-gray-500 text-lg font-medium">Belum ada data tipe pembayaran</p>
                                                <p class="text-gray-400 text-sm mt-1">Klik tombol "Tambah Tipe Pembayaran" untuk menambahkan data</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($tipePembayarans->hasPages())
                        <div class="mt-6">
                            <div class="flex items-center justify-between bg-white px-4 py-3 rounded-lg shadow">
                                <div class="flex-1 flex justify-between sm:hidden">
                                    @if ($tipePembayarans->onFirstPage())
                                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-gray-100 border border-gray-300 cursor-default rounded-md">
                                            Previous
                                        </span>
                                    @else
                                        <a href="{{ $tipePembayarans->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 rounded-md">
                                            Previous
                                        </a>
                                    @endif

                                    @if ($tipePembayarans->hasMorePages())
                                        <a href="{{ $tipePembayarans->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 rounded-md">
                                            Next
                                        </a>
                                    @else
                                        <span class="ml-3 relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-gray-100 border border-gray-300 cursor-default rounded-md">
                                            Next
                                        </span>
                                    @endif
                                </div>
                                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                    <div>
                                        <p class="text-sm text-gray-700">
                                            Menampilkan
                                            <span class="font-medium">{{ $tipePembayarans->firstItem() }}</span>
                                            sampai
                                            <span class="font-medium">{{ $tipePembayarans->lastItem() }}</span>
                                            dari
                                            <span class="font-medium">{{ $tipePembayarans->total() }}</span>
                                            hasil
                                        </p>
                                    </div>
                                    <div>
                                        {{ $tipePembayarans->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>