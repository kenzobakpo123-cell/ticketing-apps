<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Tipe Pembayaran
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Header -->
                    <div class="mb-6 pb-4 border-b border-gray-200">
                        <h3 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                            <svg class="w-7 h-7 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Form Tambah Tipe Pembayaran Baru
                        </h3>
                        <p class="text-sm text-gray-600 mt-2">Lengkapi form di bawah untuk menambahkan tipe pembayaran baru</p>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('admin.tipe-pembayaran.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
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
                                       value="{{ old('nama') }}"
                                       class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200 @error('nama') border-red-500 @enderror" 
                                       placeholder="Contoh: Transfer Bank, E-Wallet, Cash, QRIS" 
                                       required>
                            </div>
                            @error('nama')
                                <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="mt-2 text-xs text-gray-500">Masukkan nama metode pembayaran yang akan digunakan</p>
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
                                          class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-200 @error('deskripsi') border-red-500 @enderror" 
                                          placeholder="Deskripsi metode pembayaran (opsional)&#10;Contoh: Pembayaran melalui transfer bank ke rekening perusahaan">{{ old('deskripsi') }}</textarea>
                            </div>
                            @error('deskripsi')
                                <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="mt-2 text-xs text-gray-500">Berikan penjelasan singkat tentang metode pembayaran ini</p>
                        </div>

                        <!-- Status Aktif -->
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <label class="flex items-start cursor-pointer">
                                <div class="flex items-center h-5">
                                    <input type="checkbox" 
                                           id="is_active"
                                           name="is_active" 
                                           value="1" 
                                           {{ old('is_active', true) ? 'checked' : '' }}
                                           class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2 transition duration-200">
                                </div>
                                <div class="ml-3">
                                    <span class="text-sm font-semibold text-gray-900">Aktifkan Tipe Pembayaran</span>
                                    <p class="text-xs text-gray-500 mt-1">Tipe pembayaran yang aktif akan dapat digunakan oleh user saat melakukan transaksi</p>
                                </div>
                            </label>
                        </div>

                        <!-- Divider -->
                        <div class="border-t border-gray-200 pt-6">
                            <!-- Info Box -->
                            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6 rounded-r-lg">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-blue-700">
                                            <span class="font-semibold">Tips:</span> Pastikan nama tipe pembayaran jelas dan mudah dipahami oleh pengguna
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="flex items-center gap-3">
                                <button type="submit" 
                                        class="inline-flex items-center px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg transition duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Simpan Tipe Pembayaran
                                </button>
                                
                                <a href="{{ route('admin.tipe-pembayaran.index') }}" 
                                   class="inline-flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg transition duration-300 shadow-md hover:shadow-lg">
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

            <!-- Preview Card (Optional) -->
            <div class="mt-6 bg-gradient-to-r from-blue-50 to-indigo-50 overflow-hidden shadow-sm sm:rounded-lg border border-blue-200">
                <div class="p-6">
                    <h4 class="text-lg font-bold text-gray-800 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Informasi
                    </h4>
                    <ul class="space-y-2 text-sm text-gray-700">
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Field yang bertanda <span class="text-red-500 font-bold">*</span> wajib diisi</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Tipe pembayaran dapat dinonaktifkan kapan saja dari halaman edit</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Gunakan nama yang jelas dan mudah dipahami oleh pengguna</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>