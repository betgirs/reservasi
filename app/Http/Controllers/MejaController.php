<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use Inertia\Inertia;

use Illuminate\Http\Request;

class MejaController extends Controller
{
    public function index(){
       $mejas = Meja::all();
     
        return Inertia::render('Admin/Meja/Index',
            ['mejas'=>$mejas]
        );
    }
    

    public function create(){
        return Inertia::render('Admin/Meja/Create');
    }

    public function store( Request $request){
        $request->validate([
            'jumlah_orang' =>'required|integer'
        ]);

        Meja::create($request->all());

        return redirect()->route('IndexMeja')->with('success', 'Meja berhasil ditambahkan.');
    }

    public function edit($id_meja){
        $meja = Meja::findOrFail($id_meja);
       return Inertia::render('Admin/Meja/Edit',['meja' =>$meja]);
    }

    public function update(Request $request, $id_meja){
        $meja = Meja::findOrFail($id_meja);
        $request->validate([
            'jumlah_orang'=> 'required|integer'
        ]);

        $meja->update($request->all());

        return redirect()->route('IndexMeja')->with('success', 'Meja berhasil diubah.');
    }

  
    public function destroy($id_meja)
    {
    $meja = Meja::with('reservasis')->findOrFail($id_meja);

    
    foreach ($meja->reservasis as $reservasi) {
        if ($reservasi->status !== 'finished') {
            return redirect()->back()->withErrors('Tidak dapat menghapus meja yang masih memiliki reservasi aktif.');
        }
    }

    $meja->delete();

    return redirect()->back()->with('success', 'Meja berhasil dihapus.');
    }

    public function indexcoba(){
        $title='Homeeee';
        return Inertia::render('coba',[
            'title' =>$title
        ]);
    }

   
}
