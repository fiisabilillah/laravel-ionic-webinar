<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::paginate(10);
        return response()->json([
            'success'=>true,
            'data'=>$barangs
        ],201);
    }

    public function detail($id)
    {
        $barangs = Barang::find($id);
        return response()->json([
            'success'=>true,
            'data'=>$barangs
        ],201);
    }

    public function cari(Request $request)
    {
        $keyword = $request->q;
        $barangs = Barang::where('nama_barang', 'like', "%$keyword%")->get();
        return response()->json([
            'success'=>true,
            'data'=>$barangs
        ],201);

    }

}
