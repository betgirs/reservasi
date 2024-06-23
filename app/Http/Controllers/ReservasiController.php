<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use App\Models\Menu;
use App\Models\Reservasi;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservasiController extends Controller
{
    public function konfirmasiReservasi(){
        return Inertia::render('Admin/Reservasi/index');
    }
    public function indexAdmin(){
        
        $reservasis = Reservasi::with(['user','meja'])->get();
        return Inertia::render('Admin/Reservasi/index',['reservasis' => $reservasis]);
    }
    public function indexFilter(Request $request){
        $tanggal_reservasi = $request->input('tanggal_reservasi');
        $waktu_reservasi = $request->input('waktu_reservasi');

        $query= Reservasi::with(['user','meja']);

        if($tanggal_reservasi){
            $query->whereDate('tanggal_reservasi', $tanggal_reservasi);
        }
        if($waktu_reservasi){
            $query->whereTime('waktu_reservasi', $waktu_reservasi);

        }

        $reservasis = $query->get();

        return Inertia::render('Admin/Reservasi/index',['reservasis' => $reservasis]);
    }

    public function updateStatus(Request $request, $id_reservasi){
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,finished'
        ]);

        $reservasi = Reservasi::findOrFail($id_reservasi);
        $reservasi->status = $request->status;
        $reservasi->save();

        return redirect()->route('konfirmasiReservasi')->with('success', 'Status reservasi berhasil diperbarui.');
    }
   

    public function index(){
        $user = Auth::user();
        $reservasis = Reservasi::with(['user','meja'])->where('id_user',$user->id)->get();
        return Inertia::render('User/daftarReservasi',['reservasis' => $reservasis]);
    }

    public function create(){
        $mejas = Meja::all();
        return Inertia::render('User/createReservasi',['mejas' =>$mejas]);
    }

    public function store( Request $request){
        $request->validate([
            'tanggal_reservasi' => 'required|date',
            'waktu_reservasi' => 'required|date_format:H:i',
            'id_meja'=>'required|exists:mejas,id_meja'
        ]);

        $user = Auth::user();

        $reservasi = new Reservasi();
        $reservasi->id_user = $user->id;
        $reservasi->id_meja = $request->id_meja;
        $reservasi->tanggal_reservasi = $request->tanggal_reservasi;
        $reservasi->waktu_reservasi = $request->waktu_reservasi;
        $reservasi->save();

        return redirect()->route('daftarReservasi')->with('success', 'Reservasi berhasil ditambahkan.');;
    }

    public function show($id_reservasi){
        $reservasi = Reservasi::with(['pesanans.menu','user','meja','pembayaran'])->findOrFail($id_reservasi);
        $menus = Menu::all();
        return Inertia::render('User/detail',['reservasi'=>$reservasi, 'menus'=>$menus]);
    }
}
