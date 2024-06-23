<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Pembayaran;
use Inertia\Inertia;
use App\Models\Reservasi;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    // public function konfirmasiPembayaran(){
    //     return Inertia::render('Admin/konfirmasiPembayaran/index');
    // }
    public function index(){
        
        $pembayaran = Pembayaran::with(['reservasi'])->get();
        return Inertia::render('Admin/konfirmasiPembayaran/index',['pembayaran' => $pembayaran]);
    }

    public function updateStatus(Request $request, $id_pembayaran){
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled'
        ]);

        $pembayaran = Pembayaran::findOrFail($id_pembayaran);
        $pembayaran->status = $request->status;
        $pembayaran->save();

        return redirect()->route('daftarPembayaran')->with('success', 'Status pembayaran berhasil diperbarui.');
    }
    public function show($id_reservasi){
        $reservasi = Reservasi::with(['pesanans.menu','user','meja','pembayaran'])->findOrFail($id_reservasi);
        $menus = Menu::all();
        $pembayaran = $reservasi->pembayaran;

        if ($pembayaran && $pembayaran->bukti_pembayaran) {
            $pembayaran->bukti_pembayaran_url = asset('storage/' . $pembayaran->bukti_pembayaran); // Generate URL
        }

        return Inertia::render('Admin/konfirmasiPembayaran/detail',['reservasi'=>$reservasi, 'menus'=>$menus]);
    }

// UNTUK USER
    public function create($id_reservasi){
        $reservasi = Reservasi::findOrFail($id_reservasi);
        return Inertia::render('User/bayar',['reservasi'=>$reservasi]);
    }

    public function store(Request $request, $id_reservasi){
      
            $request->validate([
                'id_reservasi' =>'required|Exists:reservasis,id_reservasi',
                'tanggal_pembayaran' => 'required|date',
                'total_pembayaran'=>'required|numeric',
                'bukti_pembayaran'=> 'required|file|mimes:jpg,4jpeg,png,pdf|max:2048'
            ]);

            
            if ($request->hasFile('bukti_pembayaran')) {
                $filePath = $request->file('bukti_pembayaran')->store('uploads', 'public'); // Store file in 'storage/app/public/uploads'
                $fileUrl = asset('storage/' . $filePath); // Generate URL
            }

            Pembayaran::create([
                'id_reservasi' => $request->id_reservasi,
                'tanggal_pembayaran' => $request->tanggal_pembayaran,
                'total_pembayaran' => $request->total_pembayaran,
                'bukti_pembayaran' => $fileUrl ?? null,
            ]);
            return redirect()->route('detailReservasi', ['id_reservasi' => $id_reservasi])->with('success', 'Pembayaran berhasil dilakukan.');
      
        
    }

}
