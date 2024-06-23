<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    // public function index(){
    //     $menus = Menu::all();
    //     return Inertia::render('Admin/Menu/indexMenu',
    //     ['menus'=>$menus]);
    // }
    public function index()
    {
        $menus = Menu::all()->map(function ($menu) {
            return [
                'id_menu' => $menu->id_menu,
                'nama_menu' => $menu->nama_menu,
                'harga' => $menu->formatted_harga,  
            ];
        });

        return Inertia::render('Admin/Menu/indexMenu', [
            'menus' => $menus,
        ]);
    }

    
    public function create(){
        return Inertia::render('Admin/Menu/Create');
    }

    public function store(Request $request){
        $request->validate([
            'nama_menu'=> 'required|string|max:50',
            'harga'=>'required|numeric',
        ]);

        Menu::create($request->all());

        return redirect()->route('IndexMenu')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function edit($id_menu){
        $menu = Menu::findOrFail($id_menu);
        Return Inertia::render('Admin/Menu/Edit',['menu'=> $menu]);
    }
    public function update(Request $request, $id_menu){
        $menu=Menu::findOrFail($id_menu);
        $request->validate([
            'nama_menu' => 'required|string|max:50',
            'harga' =>'required|numeric'
        ]);

        $menu->update($request->all());
        return redirect()->route('IndexMenu')->with('success', 'Menu berhasil dihapus.');
    }


    public function destroy($id_menu)
    {
        $menu = Menu::findOrFail($id_menu);
        $menu->delete();

        return redirect()->back()->with('success', 'Menu berhasil dihapus.');
    }
    

}
