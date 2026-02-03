<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index()
    {
        return view('pages.products.index');
    }

    /**
     * Endpoint DataTables server-side sederhana (tanpa Yajra).
     * Mendukung: search global (title/description), order, paging.
     */
    public function getDataProduct(Request $req)
    {
        $draw   = (int) $req->input('draw');
        $start  = (int) $req->input('start', 0);
        $length = (int) $req->input('length', 10);
        $search = $req->input('search.value');
        $filterJual = $req->input('filter_jual');
        
        $query = Product::with([
            'kategori',
            'status'
        ]);

        if ($filterJual === 'jual') {
            $query->whereHas('status', function ($q) {
                $q->where('nama_status', 'bisa dijual');
            });
        }

        if ($filterJual === 'tidak') {
            $query->whereHas('status', function ($q) {
                $q->where('nama_status', '!=', 'bisa dijual');
            });
        }
        
        $recordsTotal = $query->count();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_produk', 'like', "%{$search}%")
                ->orWhere('harga', 'like', "%{$search}%")
                ->orWhereHas('kategori', function ($k) use ($search) {
                    $k->where('nama_kategori', 'like', "%{$search}%");
                })
                ->orWhereHas('status', function ($s) use ($search) {
                    $s->where('nama_status', 'like', "%{$search}%");
                });
            });
        }

        $recordsFiltered = $query->count();

        $data = $query
        ->offset($start)
        ->limit($length)
        ->get()
        ->map(function ($p) {
            return [
                'id'          => $p->id_produk,
                'id_produk'   => $p->id_produk,
                'nama_produk' => $p->nama_produk,
                'harga'       => $p->harga,
                'kategori'    => [
                    'nama' => $p->kategori?->nama_kategori
                ],
                'status'      => [
                    'nama' => $p->status?->nama_status
                ],
            ];
        });

        return response()->json([
            'draw'            => $draw,
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $data,
        ]);
    }

    public function show(Product $product)
    {
        return response()->json([
            'message' => 'OK',
            'data'    => $product,
        ]);
    }

    public function store(Request $req)
    {
        $data = $req->validate([
            'nama_produk' => ['required', 'string', 'max:255'],
            'harga'       => ['required', 'numeric'],
            'kategori_id' => ['required', 'exists:kategori,id_kategori'],
            'status_id'   => ['required', 'exists:status,id_status'],
        ]);

        $product = Product::create($data);

        return response()->json([
            'message' => 'Produk berhasil ditambahkan',
            'data'    => $product,
        ], 201);
    }

    public function update(Request $req, Product $product)
    {
        $data = $req->validate([
            'nama_produk' => ['required', 'string', 'max:255'],
            'harga'       => ['required', 'numeric'],
            'kategori_id' => ['required', 'exists:kategori,id_kategori'],
            'status_id'   => ['required', 'exists:status,id_status'],
        ]);

        $product->update([
            'nama_produk' => $data['nama_produk'],
            'harga'       => $data['harga'],
            'kategori_id' => $data['kategori_id'],
            'status_id'   => $data['status_id'],
        ]);

        return response()->json([
            'message' => 'Produk berhasil diperbarui',
            'data'    => $product->fresh(), // 🔥 biar data terbaru
        ]);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'message' => 'Produk berhasil dihapus'
        ]);
    }
}
