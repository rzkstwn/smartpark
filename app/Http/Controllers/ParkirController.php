<?php

namespace App\Http\Controllers;

use App\Models\Parkir;
use App\Models\Tarif;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Midtrans\Config;
use Midtrans\Snap;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Kendaraan;


class ParkirController extends Controller
{
    public function masuk(Request $request)
{
    // 🔥 Buat kendaraan otomatis
    $kendaraan = Kendaraan::create([
        'jenis_kendaraan' => $request->jenis_kendaraan,
        'plat_nomor' => 'AUTO-' . rand(1000,9999)
    ]);

    // 🔥 Simpan parkir
    $parkir = Parkir::create([
        'kendaraan_id' => $kendaraan->id,
        'waktu_masuk' => now(),
        'qr_code' => uniqid(),
        'status' => 'masuk'
    ]);

    return redirect('/tiket/' . $parkir->id);
}

    public function tiket($id)
    {
        $parkir = Parkir::find($id);

        if (!$parkir) {
            return "Data parkir tidak ditemukan!";
        }

        return view('parkir.tiket', compact('parkir'));
    }

  public function keluar(Request $request)
{
    $parkir = Parkir::where('qr_code', $request->qr_code)->first();

    if (!$parkir) {
        return "QR tidak ditemukan";
    }

    // waktu keluar sementara (belum disimpan)
    $waktuKeluar = now();

    // hitung durasi
   $durasi = max(1, ceil(
    \Carbon\Carbon::parse($parkir->waktu_masuk)
    ->diffInMinutes($waktuKeluar) / 60
));;

    // ambil jenis kendaraan
    $jenis = optional($parkir->kendaraan)->jenis_kendaraan;

    if (!$jenis) {
        return "Jenis kendaraan tidak ditemukan!";
    }

    // ambil tarif
    $tarif = Tarif::where('jenis_kendaraan', $jenis)->first();

    if (!$tarif) {
        return "Tarif belum diatur!";
    }

    $biaya = $durasi * $tarif->harga_per_jam;

    // 🔥 kirim ke halaman pembayaran (BELUM SAVE)
   return view('parkir.bayar', compact('parkir', 'durasi', 'biaya'));
}

public function bayar($id)
{
    $parkir = Parkir::with('kendaraan')->find($id);

    if (!$parkir) {
        return "Data tidak ditemukan";
    }

    $waktuKeluar = now();

    // 🔥 durasi dibulatkan
    $durasi = max(1, ceil(
        \Carbon\Carbon::parse($parkir->waktu_masuk)
        ->diffInMinutes($waktuKeluar) / 60
    ));

    $jenis = $parkir->kendaraan->jenis_kendaraan;
    $tarif = Tarif::where('jenis_kendaraan', $jenis)->first();

    $biaya = $durasi * ($tarif->harga_per_jam ?? 0);

    // 🔥 SIMPAN SETELAH BAYAR
    $parkir->update([
        'waktu_keluar' => $waktuKeluar,
        'biaya' => $biaya,
        'status' => 'keluar'
    ]);

    // 🔥 KE HALAMAN SUKSES
    return redirect()->route('bayar.sukses', $parkir->id);
}

 public function struk($id)
{
    $parkir = Parkir::with('kendaraan')->find($id);

    // ambil tarif berdasarkan jenis kendaraan
    $tarif = Tarif::where('jenis_kendaraan', $parkir->kendaraan->jenis_kendaraan)->first();

    return view('struk', compact('parkir', 'tarif'));
}
public function downloadStruk($id)
{
    $parkir = Parkir::with('kendaraan')->find($id);

    if (!$parkir) {
        return "Data tidak ditemukan";
    }

    $tarif = Tarif::where('jenis_kendaraan', $parkir->kendaraan->jenis_kendaraan)->first();

    $durasi = 0;
    $biaya = 0;

    if ($parkir->waktu_keluar && $tarif) {
        $durasi = max(1, \Carbon\Carbon::parse($parkir->waktu_masuk)
                    ->diffInHours($parkir->waktu_keluar));
        $biaya = $durasi * $tarif->harga_per_jam;
    }

    $pdf = Pdf::loadView('struk_pdf', compact('parkir','tarif','durasi','biaya'));

   return response($pdf->output(), 200)
    ->header('Content-Type', 'application/pdf')
    ->header('Content-Disposition', 'attachment; filename="struk-'.$parkir->id.'.pdf"');
}
public function sukses($id)
{
    $parkir = Parkir::find($id);

    return view('parkir.sukses', compact('parkir'));
}
}