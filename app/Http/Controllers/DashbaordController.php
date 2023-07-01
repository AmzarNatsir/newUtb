<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use App\Models\JualHeadModel;
use App\Models\ReceiveHeadModel;

class DashbaordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = [
            'list_bulan' => $this->list_bulan()
        ];
        return view('dashboard.index', $data);
    }

    public function dashboard_produk_terlaris($bulan=null, $tahun=null)
    {
        $top_ten_name = array();
        $top_ten_value = array();
        $produk_terlaris_bln_ini = \DB::table('jual_head')
                    ->selectRaw('common_product.kode, common_product.nama_produk, common_product.kemasan, common_unit.unit, common_merk.merk,  SUM(jual_detail.qty) as total')
                    ->join('jual_detail', 'jual_detail.head_id', '=', 'jual_head.id')
                    ->join('common_product', 'common_product.id', '=', 'jual_detail.produk_id')
                    ->join('common_unit', 'common_unit.id', '=', 'common_product.unit_id')
                    ->join('common_merk', 'common_merk.id', '=', 'common_product.merk_id')
                    ->whereMonth('jual_head.tgl_transaksi', $bulan)
                    ->whereYear('jual_head.tgl_transaksi', $tahun)
                    ->whereNull('jual_head.jenis_jual')
                    ->where('jual_head.status_approval', 1)
                    ->groupBy('jual_detail.produk_id')
                    ->orderByDesc('total')
                    ->limit(10)
                    ->get();
        if(count($produk_terlaris_bln_ini) > 0)
        {
            foreach($produk_terlaris_bln_ini as $list)
            {
                $top_ten_name[] = $list->nama_produk;
                $top_ten_value[] = $list->total;
            }
        } else {
            $top_ten_name[] = "";
            $top_ten_value[] = "";
        }
        $data = [
            'top_ten_name' => $top_ten_name,
            'top_ten_value' => $top_ten_value,
            'periode' => $this->get_bulan($bulan)." ".$tahun,
            'list_bulan' => $this->list_bulan()
        ];

        return view('dashboard.dashboard_1', $data);
    }

    public function dashboard_penjualan($tahun=null)
    {
        for($i=1; $i <= 12; $i++)
        {
            $bln = sprintf('%02s', $i);
            $query_res = JualHeadModel::whereMonth('tgl_transaksi', $bln)
                                        ->whereYear('tgl_transaksi', $tahun)
                                        ->whereNull('jenis_jual')
                                        ->where('status_approval', 1)
                                        ->whereNull('deleted_at')
                                        ->sum('total_invoice_net');

            if(empty($query_res))
            {
                $nominal = 0;
            } else {
                $nominal = $query_res;
            }
            $data_penjualan[] = $nominal;
        }
        $data = [
            'data_penjualan' => $data_penjualan,
            'periode' => $tahun,
        ];
        return view('dashboard.dashboard_2', $data);
    }

    public function dashboard_pembelian($tahun=null)
    {
        for($i=1; $i <= 12; $i++)
        {
            $bln = sprintf('%02s', $i);
            $query_res = ReceiveHeadModel::whereMonth('tgl_tiba', $bln)
                                        ->whereYear('tgl_tiba', $tahun)
                                        ->whereNull('deleted_at')
                                        ->sum('total_receive_net');

            if(empty($query_res))
            {
                $nominal = 0;
            } else {
                $nominal = $query_res;
            }
            $data_pembelian[] = $nominal;
        }
        $data = [
            'data_pembelian' => $data_pembelian,
            'periode' => $tahun,
        ];
        return view('dashboard.dashboard_3', $data);
    }
    
    public function list_bulan()
    {
        return $bln = [
            '1' => 'Januari',
            '2' => 'Februari',
            '3' => 'Maret',
            '4' => 'April',
            '5' => 'Mei',
            '6' => 'Juni',
            '7' => 'Juli',
            '8' => 'Agustus',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];
    }

    public function get_bulan($bulan)
    {
        $nama_bulan = "Undefine";
        $bln = [
           '1' => 'Januari',
           '2' => 'Februari',
           '3' => 'Maret',
           '4' => 'April',
           '5' => 'Mei',
           '6' => 'Juni',
           '7' => 'Juli',
           '8' => 'Agustus',
           '9' => 'September',
           '10' => 'Oktober',
           '11' => 'November',
           '12' => 'Desember'
        ];
        foreach($bln as $key => $val)
        {
            if($key==$bulan)
            {
                $nama_bulan = $val;
                break;
            }
        }
        return $nama_bulan;
    }
}
