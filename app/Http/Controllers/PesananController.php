<?php

namespace App\Http\Controllers;
use App\Models\Reservasi;
use App\Models\Menu;
use App\Models\Pesanan;
use Inertia\Inertia;

use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function create($id_reservasi){
        $reservasi = Reservasi::findOrFail($id_reservasi);
        $menus = Menu::all();
        $pesanans = Pesanan::where('id_reservasi', $id_reservasi)->with('menu')->get();

        return Inertia::render('User/createPesanan',
        [
            'reservasi'=>$reservasi,
            'menus' =>$menus,
            'pesanans' => $pesanans
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'id_reservasi' => 'required|exists:reservasis,id_reservasi',
            'id_menu' => 'required|exists:menus,id_menu',
            'jumlah_pesanan' => 'required|integer|min:1',
        ]);

        Pesanan::create($request->all())->with('success', 'Pesanan berhasil ditambahkan');;
        return back();
       
    }

    public function destroy($id_pesanan){
        $pesanan = Pesanan::findOrFail($id_pesanan);
        $pesanan->delete();
    }

    public function hapusSemua($id_reservasi){
        Pesanan::where('id_reservasi', $id_reservasi)->delete();

        return redirect()->route('detailReservasi', ['id_reservasi' => $id_reservasi]);
    }
}
