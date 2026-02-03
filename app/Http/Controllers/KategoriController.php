<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function list()
    {
        return response()->json([
            'data' => Kategori::select(
                'id_kategori as id',
                'nama_kategori as nama'
            )->get()
        ]);
    }
}
