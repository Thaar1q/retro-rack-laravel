@extends('layouts.admin')

@section('title', 'Detail Transaksi - Admin RetroRack')

@section('content')
<div class="admin-header-row" style="margin-bottom: 24px;">
    <div>
        <a href="{{ route('admin.transaksi') }}" style="display: inline-flex; align-items: center; gap: 8px; font-size: 13px; color: var(--color-text-light); margin-bottom: 16px; transition: color 0.2s; text-transform: uppercase; font-weight: 700; letter-spacing: 1px;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Kembali ke Daftar Transaksi
        </a>
        <span class="dash"></span>
        <h1 class="admin-page-title serif">Detail Transaksi</h1>
        <div style="font-size: 13px; color: var(--color-text-light); font-family: monospace; letter-spacing: 1px; margin-top: 8px;">
            #{{ $order->invoice_number }}
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="cursor: pointer; margin-left: 4px; vertical-align: middle;"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
        </div>
    </div>
    <div style="display: flex; gap: 12px;">
        <button class="btn btn-outline" style="padding: 10px 20px; font-size: 13px;">Cetak Invoice</button>
        <button class="btn btn-dark" style="padding: 10px 20px; font-size: 13px; display: inline-flex; align-items: center; gap: 8px;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
            Hubungi Pembeli
        </button>
    </div>
</div>

<div class="admin-card" style="margin-bottom: 32px; padding: 32px 0;">
    <div class="transaction-timeline">
        <div class="timeline-line"></div>
        <div class="timeline-progress" style="width: 50%;"></div>
        
        <div class="timeline-step {{ in_array($order->status, ['pending', 'processing', 'shipped', 'completed']) ? 'active' : '' }}">
            <div class="timeline-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
            </div>
            <div class="timeline-label">Pesanan Dibuat</div>
        </div>
        <div class="timeline-step {{ in_array($order->status, ['paid', 'shipped', 'completed']) ? 'active' : '' }} {{ $order->status === 'pending' ? 'current' : '' }}">
            <div class="timeline-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
            </div>
            <div class="timeline-label">Pembayaran</div>
        </div>
        <div class="timeline-step {{ in_array($order->status, ['shipped', 'completed']) ? 'active' : '' }} {{ $order->status === 'paid' ? 'current' : '' }}">
            <div class="timeline-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="4"></circle></svg>
            </div>
            <div class="timeline-label">Diproses</div>
        </div>
        <div class="timeline-step {{ in_array($order->status, ['completed']) ? 'active' : '' }} {{ $order->status === 'shipped' ? 'current' : '' }}">
            <div class="timeline-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
            </div>
            <div class="timeline-label">Dikirim</div>
        </div>
        <div class="timeline-step {{ $order->status === 'completed' ? 'active' : '' }}">
            <div class="timeline-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"></path><line x1="4" y1="22" x2="4" y2="15"></line></svg>
            </div>
            <div class="timeline-label">Selesai</div>
        </div>
    </div>
</div>

<div class="admin-form-container">
    <div class="admin-form-main">
        <div class="admin-form-section">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                <h2 class="admin-form-title" style="font-size: 13px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0;">Item Pesanan</h2>
                <div style="font-size: 13px; color: var(--color-text-light);">3 Items</div>
            </div>
            
            <table class="admin-table" style="margin: 0 -32px; width: calc(100% + 64px);">
                <thead>
                    <tr>
                        <th style="padding-left: 32px;">PRODUK</th>
                        <th style="text-align: center;">QTY</th>
                        <th style="text-align: right; padding-right: 32px;">HARGA</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->details as $detail)
                    <tr>
                        <td style="padding-left: 32px;">
                            <div style="display: flex; align-items: center; gap: 16px;">
                                <div style="width: 48px; height: 48px; background-color: var(--color-border); border-radius: 8px; background-image: url('{{ $detail->product->imageUrl() }}'); background-size: cover; background-position: center;"></div>
                                <div>
                                    <div style="font-weight: 700; color: var(--color-dark); font-size: 14px;">{{ $detail->product_name }}</div>
                                    <div style="font-size: 12px; color: var(--color-text-light);">{{ $detail->product->category->name ?? 'Produk' }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="text-align: center;">{{ $detail->quantity }}</td>
                        <td style="text-align: right; padding-right: 32px; font-weight: 700;">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
            <div class="admin-form-section" style="margin-bottom: 0;">
                <h2 class="admin-form-title" style="font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">Informasi Pengiriman</h2>
                
                <div style="margin-bottom: 16px;">
                    <div style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: var(--color-text-light); margin-bottom: 4px;">NAMA PENERIMA</div>
                    <div style="font-weight: 600; color: var(--color-dark);">{{ $order->user->name }}</div>
                </div>
                
                <div style="margin-bottom: 16px;">
                    <div style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: var(--color-text-light); margin-bottom: 4px;">TELEPON</div>
                    <div style="color: var(--color-dark);">-</div>
                </div>
                
                <div style="margin-bottom: 24px;">
                    <div style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: var(--color-text-light); margin-bottom: 4px;">ALAMAT LENGKAP</div>
                    <div style="color: var(--color-dark); line-height: 1.5;">Alamat pelanggan belum tersedia.</div>
                </div>
                
                <div style="display: flex; gap: 12px; align-items: center; padding: 12px; background-color: #fafafa; border: 1px solid var(--color-border); border-radius: 8px;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--color-primary);"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                    <div>
                        <div style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: var(--color-text-light);">KURIR</div>
                        <div style="font-weight: 600; color: var(--color-dark); font-size: 13px;">JNE Reguler (3-4 hari)</div>
                    </div>
                </div>
            </div>

            <div class="admin-form-section" style="margin-bottom: 0;">
                <h2 class="admin-form-title" style="font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">Bukti Pembayaran</h2>
                
                <div style="background-color: #fafafa; border: 1px solid var(--color-border); border-radius: 12px; overflow: hidden; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                    <div style="width: 100%; height: 160px; background-color: #e5e5e5; display: flex; align-items: center; justify-content: center; position: relative;">
                        <!-- Mock phone graphic inside -->
                        <div style="width: 80px; height: 140px; border-radius: 12px; background-color: #fff; border: 2px solid #ccc; box-shadow: 0 4px 10px rgba(0,0,0,0.1); margin-top: 20px; overflow: hidden;">
                            <div style="width: 100%; height: 20px; border-bottom: 1px solid #eee; display: flex; align-items: center; justify-content: center;"><div style="width: 20px; height: 4px; background-color: #eee; border-radius: 2px;"></div></div>
                            <div style="padding: 8px;">
                                <div style="width: 100%; height: 6px; background-color: #eee; margin-bottom: 6px;"></div>
                                <div style="width: 80%; height: 6px; background-color: #eee; margin-bottom: 6px;"></div>
                                <div style="width: 90%; height: 6px; background-color: #eee; margin-bottom: 16px;"></div>
                                <div style="width: 100%; height: 1px; background-color: #eee; margin-bottom: 12px;"></div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 4px;"><div style="width: 30%; height: 4px; background-color: #eee;"></div><div style="width: 30%; height: 4px; background-color: #ccc;"></div></div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 4px;"><div style="width: 30%; height: 4px; background-color: #eee;"></div><div style="width: 30%; height: 4px; background-color: #ccc;"></div></div>
                            </div>
                        </div>
                    </div>
                    <div style="padding: 16px; text-align: center; width: 100%;">
                        <div style="font-size: 13px; font-weight: 600; color: var(--color-dark); margin-bottom: 4px; cursor: pointer;">Lihat Gambar Penuh</div>
                        <div style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: var(--color-text-light);">DIVERIFIKASI VIA BCA MOBILE</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-form-section">
            <h2 class="admin-form-title" style="font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">Catatan Admin</h2>
            <textarea class="admin-form-textarea" placeholder="Tulis catatan internal di sini..." style="margin-bottom: 16px; min-height: 100px;"></textarea>
            <div style="text-align: right;">
                <button class="btn btn-dark" style="padding: 10px 24px; font-size: 13px;">Simpan Catatan</button>
            </div>
        </div>
    </div>

    <div class="admin-form-sidebar">
        <div class="admin-sidebar-card">
            <div style="display: flex; gap: 16px; align-items: center;">
                <div style="width: 48px; height: 48px; border-radius: 50%; background-color: var(--color-primary); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 18px;">
                    {{ strtoupper(substr($order->user->name, 0, 1)) }}
                </div>
                <div>
                    <div style="font-weight: 700; color: var(--color-dark); font-size: 15px;">{{ $order->user->name }}</div>
                    <div style="font-size: 12px; color: var(--color-text-light);">Member Since: {{ $order->user->created_at->format('M Y') }}</div>
                    <div style="font-size: 11px; font-weight: 700; color: var(--color-primary); display: flex; align-items: center; gap: 4px; margin-top: 4px;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        Terverifikasi
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-sidebar-card">
            <h3 class="admin-sidebar-title">Update Status</h3>
            <form action="{{ route('admin.transaksi.status', $order) }}" method="POST">
                @csrf
                @method('PATCH')
                <select name="status" class="admin-form-input" style="margin-bottom: 16px;">
                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Diproses</option>
                    <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Dikirim</option>
                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
                <button type="submit" class="btn btn-dark" style="width: 100%; padding: 14px; font-size: 12px; letter-spacing: 1px;">UPDATE STATUS</button>
            </form>
        </div>

        <div class="admin-sidebar-card">
            <h3 class="admin-sidebar-title">Nomor Resi</h3>
            <input type="text" class="admin-form-input" placeholder="Masukkan nomor resi..." style="margin-bottom: 16px;">
            <button class="btn btn-outline" style="width: 100%; padding: 12px; font-size: 13px; display: inline-flex; align-items: center; justify-content: center; gap: 8px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                Cetak Label Pengiriman
            </button>
        </div>

        <div class="admin-sidebar-card" style="border-color: var(--color-primary); background-color: #fffbeb;">
            <h3 class="admin-sidebar-title" style="border-color: #fde68a;">Ringkasan Pesanan</h3>
            <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 13px; color: var(--color-text);">
                <span>Subtotal</span>
                <span style="font-weight: 600; color: var(--color-dark);">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 13px; color: var(--color-text);">
                <span>Biaya Admin (0%)</span>
                <span style="font-weight: 600; color: var(--color-dark);">Rp 0</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 24px; font-size: 13px; color: var(--color-text);">
                <span>Ongkos Kirim</span>
                <span style="font-weight: 600; color: var(--color-dark);">Gratis</span>
            </div>
            <div style="border-top: 1px solid #fde68a; padding-top: 16px; display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 14px; font-weight: 700; color: var(--color-dark);">Total Pembayaran</span>
                <span style="font-size: 18px; font-weight: 700; color: var(--color-primary);">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
        </div>
        
        <div class="admin-sidebar-card" style="background-color: #fafafa;">
            <form action="{{ route('admin.transaksi.status', $order) }}" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="cancelled">
                <button type="submit" class="btn btn-outline" style="width: 100%; border-color: #fee2e2; color: #dc2626; display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; font-weight: 700; background-color: #fff;" onclick="return confirm('Yakin ingin membatalkan pesanan ini?');">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                    Batalkan Pesanan
                </button>
            </form>
            <div style="font-size: 10px; color: var(--color-text-light); text-align: center; margin-top: 12px; font-style: italic;">
                Pembatalan hanya dapat dilakukan jika pesanan belum dikirim.
            </div>
        </div>
    </div>
</div>
@endsection
