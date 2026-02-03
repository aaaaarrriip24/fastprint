<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function list()
    {
        return response()->json([
            'data' => Status::select(
                'id_status as id',
                'nama_status as nama'
            )->get()
        ]);
    }
}
