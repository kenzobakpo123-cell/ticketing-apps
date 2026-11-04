<x-layouts.app>
  <section class="max-w-7xl mx-auto py-12 px-6">
    <nav class="mb-6">
      <div class="breadcrumbs">
        <ul>
          <li><a href="{{ route('home') }}" class="link link-neutral">Beranda</a></li>
          <li><a href="#" class="link link-neutral">Event</a></li>
          <li>{{ $event->judul }}</li>
        </ul>
      </div>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Left / Main area -->
      <div class="lg:col-span-2">
        <div class="card bg-base-100 shadow">
          <figure>
            <img
    src="{{ $event->gambar
        ? (filter_var($event->gambar, FILTER_VALIDATE_URL) ? $event->gambar : asset('images/events/' . $event->gambar))
        : asset('images/events/1769062679.jpg')
    }}"
    alt="{{ $event->judul }}"
    class="w-full h-96 object-cover"
/>
          </figure>
          <div class="card-body">
            <div class="flex justify-between items-start gap-4">
              <div>
                <h1 class="text-3xl font-extrabold">{{ $event->judul }}</h1>
                <p class="text-sm text-gray-500 mt-1">
                  {{ \Carbon\Carbon::parse($event->tanggal_waktu)->locale('id')->translatedFormat('d F Y, H:i') }} • 📍
                  {{ $event->lokasi }}
                </p>

                <div class="mt-3 flex gap-2 items-center">
                  <span class="badge badge-primary">{{ $event->kategori?->nama ?? 'Tanpa Kategori' }}</span>
                  <span class="badge">{{ $event->user?->name ?? 'Penyelenggara' }}</span>
                </div>
              </div>

            </div>

            <p class="mt-4 text-gray-700 leading-relaxed">{{ $event->deskripsi }}</p>

            <div class="divider"></div>

            <h3 class="text-xl font-bold">Pilih Tiket</h3>

            <div class="mt-4 space-y-4">
              @forelse($event->tikets as $tiket)
              <div class="card card-side shadow-sm p-4 items-center">
                <div class="flex-1">
                  <h4 class="font-bold">{{ $tiket->tipe }}</h4>
                  <p class="text-sm text-gray-500">
                    {{ $tiket->stok > 0 ? 'Stok tersedia:' : 'Tiket habis' }}
                    <span id="stock-{{ $tiket->id }}">{{ $tiket->stok }}</span>
                  </p>
                  <p class="text-sm mt-2">{{ $tiket->keterangan ?? '' }}</p>
                </div>

                <div class="w-44 text-right">
                  <div class="text-lg font-bold">
                    {{ $tiket->harga ? 'Rp ' . number_format($tiket->harga, 0, ',', '.') : 'Gratis' }}
                  </div>

                  <div class="mt-3 flex items-center justify-end gap-2">
                    <button type="button" class="btn btn-sm btn-outline" data-action="dec" data-id="{{ $tiket->id }}"
                      aria-label="Kurangi satu" {{ $tiket->stok < 1 ? 'disabled' : '' }}>−</button>
                    <input id="qty-{{ $tiket->id }}" type="number" min="0" max="{{ $tiket->stok }}" value="0"
                      class="input input-bordered w-16 text-center" data-id="{{ $tiket->id }}" {{ $tiket->stok < 1 ? 'disabled' : '' }} />
                    <button type="button" class="btn btn-sm btn-outline" data-action="inc" data-id="{{ $tiket->id }}"
                      aria-label="Tambah satu" {{ $tiket->stok < 1 ? 'disabled' : '' }}>+</button>
                  </div>

                  <div class="text-sm text-gray-500 mt-2">Subtotal: <span id="subtotal-{{ $tiket->id }}">Rp 0</span>
                  </div>
                </div>
              </div>
              @empty
              <div class="alert alert-info">Tiket belum tersedia untuk acara ini.</div>
              @endforelse
            </div>

          </div>
        </div>
      </div>

      <!-- Right / Summary -->
      <aside class="lg:col-span-1">
        <div class="card sticky top-24 p-4 bg-base-100 shadow">
          <h4 class="font-bold text-lg">Ringkasan Pembelian</h4>

          <div class="mt-4">
            <div class="flex justify-between text-sm text-gray-500"><span>Item</span><span id="summaryItems">0</span>
            </div>
            <div class="flex justify-between text-xl font-bold mt-1"><span>Total</span><span id="summaryTotal">Rp
                0</span></div>
          </div>

          <div class="divider"></div>

          <div id="selectedList" class="space-y-2 text-sm text-gray-700">
            <p class="text-gray-500">Belum ada tiket dipilih</p>
          </div>

          @auth
            <button id="checkoutButton" class="btn btn-primary !bg-blue-900 text-white btn-block mt-6" onclick="openCheckout()" disabled>Checkout</button>
          @else
            <a href="{{ route('login') }}" class="btn btn-primary btn-block mt-6 text-white">Login untuk Checkout</a>
          @endauth

        </div>
      </aside>
    </div>

    <!-- Checkout Modal -->
    <dialog id="checkout_modal" class="modal">
      <form method="dialog" class="modal-box">
        <h3 class="font-bold text-lg">Konfirmasi Pembelian</h3>
        <div class="mt-4 space-y-2 text-sm">
        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
          <label for="paymentMethod" class="block text-sm font-semibold text-slate-800">Metode pembayaran</label>
          <select id="paymentMethod" class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100" {{ $paymentMethods->isEmpty() ? 'disabled' : '' }}>
            <option value="">Pilih metode pembayaran</option>
            @foreach($paymentMethods as $paymentMethod)
              <option value="{{ $paymentMethod->id }}" data-instructions="{{ $paymentMethod->deskripsi }}">{{ $paymentMethod->nama }}</option>
            @endforeach
          </select>
          <p id="paymentInstructions" class="mt-2 text-xs leading-5 text-slate-500">
            @if($paymentMethods->isEmpty())
              Metode pembayaran belum tersedia. Silakan hubungi admin.
            @else
              Instruksi pembayaran akan ditampilkan setelah memilih metode.
            @endif
          </p>
        </div>
        <div id="modalItems">
          <p class="text-gray-500">Belum ada item.</p>
        </div>

          <div class="divider"></div>
          <div class="flex justify-between items-center">
            <span class="font-bold">Total</span>
            <span class="font-bold text-lg" id="modalTotal">Rp 0</span>
          </div>
        </div>

        <div class="modal-action">
          <button class="btn">Tutup</button>
          <button type="button" class="btn btn-primary px-4 !bg-blue-900 text-white" id="confirmCheckout" disabled>Konfirmasi</button>
        </div>
      </form>
    </dialog>

  </section>

  <script>
    (function () {
      // Helper to format Indonesian currency
      const formatRupiah = (value) => {
        return 'Rp ' + Number(value).toLocaleString('id-ID');
      }

      const tickets = {
        @foreach($event->tikets as $tiket)
              {{ $tiket->id }}: {
            id: {{ $tiket->id }},
            price: {{ $tiket->harga ?? 0 }},
            stock: {{ $tiket->stok }},
            tipe: @json($tiket->tipe)
          },
        @endforeach
      };

    const summaryItemsEl = document.getElementById('summaryItems');
    const summaryTotalEl = document.getElementById('summaryTotal');
    const selectedListEl = document.getElementById('selectedList');
    const checkoutButton = document.getElementById('checkoutButton');
    const paymentMethodEl = document.getElementById('paymentMethod');
    const paymentInstructionsEl = document.getElementById('paymentInstructions');
    const confirmCheckoutButton = document.getElementById('confirmCheckout');

    function updateSummary() {
      let totalQty = 0;
      let totalPrice = 0;
      let selectedHtml = '';

      Object.values(tickets).forEach(t => {
        const qtyInput = document.getElementById('qty-' + t.id);
        if (!qtyInput) return;
        const qty = Number(qtyInput.value || 0);
        if (qty > 0) {
          totalQty += qty;
          totalPrice += qty * t.price;
          selectedHtml += `<div class="flex justify-between"><span>${t.tipe} x ${qty}</span><span>${formatRupiah(qty * t.price)}</span></div>`;
        }
      });

      summaryItemsEl.textContent = totalQty;
      summaryTotalEl.textContent = formatRupiah(totalPrice);
      selectedListEl.innerHTML = selectedHtml || '<p class="text-gray-500">Belum ada tiket dipilih</p>';
      checkoutButton.disabled = totalQty === 0;
    }

    paymentMethodEl?.addEventListener('change', () => {
      const option = paymentMethodEl.selectedOptions[0];
      paymentInstructionsEl.textContent = option?.dataset.instructions || 'Instruksi pembayaran akan ditampilkan setelah memilih metode.';
      confirmCheckoutButton.disabled = !paymentMethodEl.value;
      updateSummary();
    });

    // Wire up plus/minus buttons and manual input
    document.querySelectorAll('[data-action="inc"]').forEach(btn => {
      btn.addEventListener('click', (e) => {
        const id = e.currentTarget.dataset.id;
        const input = document.getElementById('qty-' + id)
        const info = tickets[id];
        if (!input || !info) return;
        let val = Number(input.value || 0);
        if (val < info.stock) val++;
        input.value = val;
        updateTicketSubtotal(id);
        updateSummary();
      });
    });

    document.querySelectorAll('[data-action="dec"]').forEach(btn => {
      btn.addEventListener('click', (e) => {
        const id = e.currentTarget.dataset.id;
        const input = document.getElementById('qty-' + id);
        if (!input) return;
        let val = Number(input.value || 0);
        if (val > 0) val--;
        input.value = val;
        updateTicketSubtotal(id);
        updateSummary();
      });
    });

    document.querySelectorAll('input[id^="qty-"]').forEach(input => {
      input.addEventListener('change', (e) => {
        const el = e.currentTarget;
        const id = el.dataset.id;
        const info = tickets[id];
        let val = Number(el.value || 0);
        if (val < 0) val = 0;
        if (val > info.stock) val = info.stock;
        el.value = val;
        updateTicketSubtotal(id);
        updateSummary();
      });
    });

    function updateTicketSubtotal(id) {
      const t = tickets[id];
      const qty = Number(document.getElementById('qty-' + id).value || 0);
      const subtotalEl = document.getElementById('subtotal-' + id);
      if (subtotalEl) subtotalEl.textContent = formatRupiah(qty * t.price);
    }

    // Checkout modal
    window.openCheckout = function () {
      const modal = document.getElementById('checkout_modal');
      // populate modal items
      const modalItems = document.getElementById('modalItems');
      const modalTotal = document.getElementById('modalTotal');

      let itemsHtml = '';
      let total = 0;
      Object.values(tickets).forEach(t => {
        const qty = Number(document.getElementById('qty-' + t.id).value || 0);
        if (qty > 0) {
          itemsHtml += `<div class="flex justify-between"><span>${t.tipe} x ${qty}</span><span>${formatRupiah(qty * t.price)}</span></div>`;
          total += qty * t.price;
        }
      });

      modalItems.innerHTML = itemsHtml || '<p class="text-gray-500">Belum ada item.</p>';
      modalTotal.textContent = formatRupiah(total);

      if (typeof modal.showModal === 'function') {
        modal.showModal();
      } else {
        // fallback for older browsers
        modal.classList.add('modal-open');
      }
    }
document.getElementById('confirmCheckout').addEventListener('click', async () => {
      const btn = document.getElementById('confirmCheckout');
      btn.setAttribute('disabled', 'disabled');
      btn.textContent = 'Memproses...';

      // gather items
      const items = [];
      Object.values(tickets).forEach(t => {
        const qty = Number(document.getElementById('qty-' + t.id).value || 0);
        if (qty > 0) items.push({ tiket_id: t.id, jumlah: qty });
      });

      if (items.length === 0) {
        alert('Tidak ada tiket dipilih');
        btn.removeAttribute('disabled');
        btn.textContent = 'Konfirmasi';
        return;
      }

      if (!paymentMethodEl?.value) {
        alert('Pilih metode pembayaran terlebih dahulu.');
        btn.removeAttribute('disabled');
        btn.textContent = 'Konfirmasi';
        return;
      }

      try {
        const res = await fetch("{{ route('orders.store') }}", {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify({
            event_id: {{ $event->id }},
            payment_method_id: Number(paymentMethodEl.value),
            items
          })
        });

        if (!res.ok) {
          const error = await res.json().catch(() => ({}));
          const message = error.message || Object.values(error.errors || {}).flat()[0] || 'Gagal membuat pesanan.';
          throw new Error(message);
        }

        const data = await res.json();
        // Redirect to the newly created order.
        window.location.href = data.redirect || '{{ route('orders.index') }}';
      } catch (err) {
        console.log(err);
        alert('Terjadi kesalahan saat memproses pesanan: ' + err.message);
        btn.removeAttribute('disabled');
        btn.textContent = 'Konfirmasi';
      }
    });
    // init
    updateSummary();
    }) ();
  </script>
</x-layouts.app>