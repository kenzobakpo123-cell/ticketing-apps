<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Tipe Pembayaran
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-4">
                        <h3 class="font-bold text-lg mb-2">Nama Tipe Pembayaran:</h3>
                        <p class="text-gray-700">{{ $tipePembayaran->nama }}</p>
                    </div>

                    <div class="mb-4">
                        <h3 class="font-bold text-lg mb-2">Deskripsi:</h3>
                        <p class="text-gray-700">{{ $tipePembayaran->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                    </div>

                    <div class="mb-4">
                        <h3 class="font-bold text-lg mb-2">Status:</h3>
                        @if($tipePembayaran->is_active)
                            <span class="badge badge-success badge-lg">Aktif</span>
                        @else
                            <span class="badge badge-error badge-lg">Nonaktif</span>
                        @endif
                    </div>

                    <div class="mb-4">
                        <h3 class="font-bold text-lg mb-2">Dibuat pada:</h3>
                        <p class="text-gray-700">{{ $tipePembayaran->created_at->format('d M Y H:i') }}</p>
                    </div>

                    <div class="mb-4">
                        <h3 class="font-bold text-lg mb-2">Terakhir diupdate:</h3>
                        <p class="text-gray-700">{{ $tipePembayaran->updated_at->format('d M Y H:i') }}</p>
                    </div>

                    <div class="flex gap-2 mt-6">
                        <a href="{{ route('admin.tipe-pembayaran.edit', $tipePembayaran) }}" class="btn btn-warning">Edit</a>
                        <a href="{{ route('admin.tipe-pembayaran.index') }}" class="btn btn-ghost">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>