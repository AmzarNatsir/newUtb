<?php

namespace App\Http\Controllers;

use App\Models\JualHeadModel;
use Illuminate\Http\Request;

class PersetujuanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function persetujuan_penjualan()
    {
        return view('persetujuan.penjualan.index');
    }

    public function persetujuan_penjualan_filter($tgl_awal=null, $tgl_akhir=null)
    {
        $result = JualHeadModel::whereDate('tgl_invoice', '>=', $tgl_awal)
                            ->whereDate('tgl_invoice', '<=', $tgl_akhir)
                            ->whereNull('jenis_jual')
                            ->whereNull('approved')
                            ->orderby('tgl_invoice', 'asc')->get();
        $data = [
            'list_data' => $result
        ];

        return view('persetujuan.penjualan.list', $data);
    }
}
