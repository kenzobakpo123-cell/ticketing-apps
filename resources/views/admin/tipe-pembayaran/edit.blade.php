<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Tipe Pembayaran
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Main Form Card -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <!-- Header -->
                    <div class="mb-6 pb-4 border-b border-gray-200">
                        <div class="flex items-center gap-3">
                            <div class="bg-yellow-100 p-3 rounded-lg">
                                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-800">Edit Tipe Pembayaran</h3>
                                <p class="text-sm text-gray-600 mt-1">Perbarui informasi tipe pembayaran: <span class="font-semibold text-yellow-600">{{ $tipePembayaran->nama }}</span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('admin.tipe-pembayaran.update', $tipePembayaran) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <!-- Nama Tipe Pembayaran -->
                        <div>
                            <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nama Tipe Pembayaran <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                    </svg>
                                </div>
                                <input type="text" 
                                       id="nama"
                                       name="nama" 
                                       value="{{ old('nama', $tipePembayaran->nama) }}"
                                       class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 transition duration-200 @error('nama') border-red-500 ring-2 ring-red-200 @enderror" 
                                       placeholder="Contoh: Transfer Bank, E-Wallet, Cash, QRIS" 
                                       required>
                            </div>
                            @error('nama')
                                <div class="mt-2 flex items-center gap-1 text-red-600 bg-red-50 px-3 py-2 rounded-md">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm">{{ $message }}</span>
                                </div>
                            @enderror
                            <p class="mt-2 text-xs text-gray-500 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                Masukkan nama metode pembayaran yang akan digunakan
                            </p>
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-2">
                                Deskripsi
                            </label>
                            <div class="relative">
                                <div class="absolute top-3 left-3 pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                                    </svg>
                                </div>
                                <textarea id="deskripsi"
                                          name="deskripsi" 
                                          rows="4"
                                          class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 transition duration-200 @error('deskripsi') border-red-500 ring-2 ring-red-200 @enderror" 
                                          placeholder="Deskripsi metode pembayaran (opsional)&#10;Contoh: Pembayaran melalui transfer bank ke rekening perusahaan">{{ old('deskripsi', $tipePembayaran->deskripsi) }}</textarea>
                            </div>
                            @error('deskripsi')
                                <div class="mt-2 flex items-center gap-1 text-red-600 bg-red-50 px-3 py-2 rounded-md">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm">{{ $message }}</span>
                                </div>
                            @enderror
                            <p class="mt-2 text-xs text-gray-500 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                Berikan penjelasan singkat tentang metode pembayaran ini
                            </p>
                        </div>

                        <!-- Status Aktif -->
                        <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg p-4 border-2 border-gray-200">
                            <label class="flex items-start cursor-pointer group">
                                <div class="flex items-center h-5">
                                    <input type="checkbox" 
                                           id="is_active"
                                           name="is_active" 
                                           value="1" 
                                           {{ old('is_active', $tipePembayaran->is_active) ? 'checked' : '' }}
                                           class="w-5 h-5 text-yellow-600 bg-white border-gray-300 rounded focus:ring-yellow-500 focus:ring-2 transition duration-200 cursor-pointer">
                                </div>
                                <div class="ml-3">
                                    <span class="text-sm font-semibold text-gray-900 group-hover:text-yellow-600 transition">Aktifkan Tipe Pembayaran</span>
                                    <p class="text-xs text-gray-600 mt-1 leading-relaxed">Tipe pembayaran yang aktif akan dapat digunakan oleh pengguna saat melakukan transaksi pembayaran</p>
                                </div>
                            </label>
                        </div>

                        <!-- Warning Box -->
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700">
                                        <span class="font-semibold">Perhatian:</span> Perubahan yang Anda buat akan langsung mempengaruhi sistem pembayaran yang sedang berjalan
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="border-t border-gray-200 pt-6">
                            <!-- Buttons -->
                            <div class="flex flex-col sm:flex-row items-center gap-3">
                                <button type="submit" 
                                        class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-3 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg transition-all duration-300 shadow-md hover:shadow-xl transform hover:-translate-y-0.5 active:translate-y-0">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    Update Tipe Pembayaran
                                </button>
                                
                                <a href="{{ route('admin.tipe-pembayaran.index') }}" 
                                   class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-3 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg transition-all duration-300 shadow-md hover:shadow-lg">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Batal
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Cards -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Created Info -->
                <div class="bg-white shadow-md rounded-lg border border-gray-200 overflow-hidden hover:shadow-lg transition duration-300">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-4 py-3">
                        <h4 class="text-sm font-bold text-white flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Tanggal Dibuat
                        </h4>
                    </div>
                    <div class="p-4">
                        <p class="text-sm font-semibold text-gray-800">{{ $tipePembayaran->created_at->format('d F Y') }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $tipePembayaran->created_at->format('H:i') }} WIB</p>
                        <p class="text-xs text-gray-400 mt-2 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                            {{ $tipePembayaran->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>

                <!-- Updated Info -->
                <div class="bg-white shadow-md rounded-lg border border-gray-200 overflow-hidden hover:shadow-lg transition duration-300">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 px-4 py-3">
                        <h4 class="text-sm font-bold text-white flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Terakhir Diubah
                        </h4>
                    </div>
                    <div class="p-4">
                        <p class="text-sm font-semibold text-gray-800">{{ $tipePembayaran->updated_at->format('d F Y') }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $tipePembayaran->updated_at->format('H:i') }} WIB</p>
                        <p class="text-xs text-gray-400 mt-2 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                            {{ $tipePembayaran->updated_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Additional Info -->
            <div class="mt-6 bg-gradient-to-br from-yellow-50 to-orange-50 overflow-hidden shadow-md sm:rounded-lg border-2 border-yellow-200">
                <div class="p-6">
                    <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <div class="bg-yellow-400 p-2 rounded-lg">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        Panduan Edit Tipe Pembayaran
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-start gap-3 bg-white p-3 rounded-lg shadow-sm">
                            <div class="flex-shrink-0">
                                <div class="bg-green-100 p-2 rounded-full">
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">Validasi Otomatis</p>
                                <p class="text-xs text-gray-600 mt-1">Sistem akan memvalidasi data sebelum menyimpan</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 bg-white p-3 rounded-lg shadow-sm">
                            <div class="flex-shrink-0">
                                <div class="bg-blue-100 p-2 rounded-full">
                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">Perubahan Langsung</p>
                                <p class="text-xs text-gray-600 mt-1">Perubahan berlaku segera setelah disimpan</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 bg-white p-3 rounded-lg shadow-sm">
                            <div class="flex-shrink-0">
                                <div class="bg-purple-100 p-2 rounded-full">
                                    <svg class="w-4 h-4 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">Status Fleksibel</p>
                                <p class="text-xs text-gray-600 mt-1">Dapat diaktifkan/nonaktifkan kapan saja</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 bg-white p-3 rounded-lg shadow-sm">
                            <div class="flex-shrink-0">
                                <div class="bg-red-100 p-2 rounded-full">
                                    <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">Dapat Dibatalkan</p>
                                <p class="text-xs text-gray-600 mt-1">Klik "Batal" untuk membatalkan perubahan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>