@extends('layout.main')
@section("content")
<style>
    /* ...existing code... */
    .report { max-width: 900px; margin: 20px auto; font-family: Arial, sans-serif; font-size: 13px; color: #222; }
    .report h2 { margin: 0 0 6px 0; }
    .meta { margin: 8px 0 14px 0; }
    .meta div { margin: 3px 0; }
    table.items { width: 100%; border-collapse: collapse; margin-top: 8px; }
    table.items th, table.items td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    table.items thead th { background: #f7f7f7; }
    table.items tfoot td { font-weight: 700; }
    .notes { margin-top: 12px; }
    .page-break { page-break-after: always; }
    @media print { body { -webkit-print-color-adjust: exact; } }
</style>

<div class="report-list">
    @if(empty($data) || count($data) == 0)
        <div class="report">
            <h2>Daftar Transaksi</h2>
            <p>Tidak ada data transaksi.</p>
        </div>
    @else
        @foreach($data as $index => $transaksi)
            <div class="report">
                <h2>Transaksi #{{ $transaksi->id ?? ($index+1) }} - {{ $transaksi->judul ?? '-' }}</h2>

                <div class="meta">
                    <div><strong>Status:</strong> {{ $transaksi->status ?? '-' }}</div>
                    <div><strong>Pabrik:</strong> {{ optional($transaksi->pabrik)->name ?? ($transaksi->nama_pabrik ?? '-') }}</div>
                    <div><strong>Pembeli:</strong> {{ optional($transaksi->pembeli)->name ?? ($transaksi->nama_pembeli ?? '-') }}</div>
                    <div><strong>Tanggal Transaksi:</strong> {{ $transaksi->tanggal_transaksi ?? '-' }}</div>
                    <div><strong>Tanggal Pengiriman:</strong> {{ $transaksi->tanggal_pengiriman ?? '-' }} &nbsp;|&nbsp; <strong>Tanggal Pembayaran:</strong> {{ $transaksi->tanggal_pembayaran ?? '-' }}</div>
                </div>

                <table class="items">
                    <thead>
                        <tr>
                            <th style="width:5%">No</th>
                            <th style="width:50%">Produk</th>
                            <th style="width:10%">Jumlah</th>
                            <th style="width:15%">Harga Satuan</th>
                            <th style="width:20%">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $grand = 0; @endphp
                        @if(!empty($transaksi->detail_tr) && count($transaksi->detail_tr) > 0)
                            @foreach($transaksi->detail_tr as $i => $d)
                                @php
                                    $jumlah = $d->jumlah ?? $d->qty ?? 0;
                                    $harga = $d->harga ?? $d->harga_satuan ?? optional($d->produk)->harga_jual ?? 0;
                                    $total = $jumlah * $harga;
                                    $grand += $total;
                                @endphp
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ optional($d->produk)->nama ?? ($d->nama_produk ?? '-') }}</td>
                                    <td>{{ $jumlah }}</td>
                                    <td>Rp {{ number_format($harga,0,',','.') }}</td>
                                    <td>Rp {{ number_format($total,0,',','.') }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" style="text-align:center">- Tidak ada detail transaksi -</td>
                            </tr>
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" style="text-align:right">Grand Total</td>
                            <td>Rp {{ number_format($grand,0,',','.') }}</td>
                        </tr>
                    </tfoot>
                </table>

                <div class="notes">
                    <strong>Catatan:</strong> {{ $transaksi->keterangan ?? '-' }}
                </div>
            </div>

            @if(!$loop->last)
                <div class="page-break"></div>
            @endif
        @endforeach
    @endif
</div>

<script>
    // Auto open print dialog when the page is loaded.
    document.addEventListener('DOMContentLoaded', function() {
        // small delay to ensure layout and fonts are ready
        setTimeout(function() {
            try {
                window.print();
            } catch (e) {
                console.error('Print failed', e);
            }
        }, 300);
    });
</script>

@endsection
