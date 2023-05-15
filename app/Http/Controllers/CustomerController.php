<?php

namespace App\Http\Controllers;

use App\Models\CustomerModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $query = CustomerModel::all();
        $data['allCustomer'] = $query;
        return view('common.customer.index', $data);
    }

    public function add()
    {
        $data = [
            'kode_baru' => $this->create_no_customer()
        ];
        return view('common.customer.add', $data);
    }

    public function store(Request $request)
    {
        try {
            $save = new CustomerModel();
            $save->kode = $request->inp_kode;
            $save->nama_customer = $request->inp_nama;
            $save->alamat = $request->inp_alamat;
            $save->kota = $request->inp_kota;
            $save->no_telepon = $request->inp_notel;
            $save->level = $request->inp_level;
            $exec = $save->save();
            if($exec)
            {
                return redirect('customer')->with('message', 'Data berhasil disimpan');
            } else {
                return redirect('customer')->with('message', 'Data gagal disimpan');
            }
        } catch (QueryException $e)
        {
            return redirect('customer')->with('message', 'Proses gagal. Error : '.$e->getMessage());
        }
    }

    public function edit($id)
    {
        $query = CustomerModel::find($id);
        $data['res'] = $query;
        return view('common.customer.edit', $data);
    }

    public function update(Request $request, $id)
    {
        try {
            $update = CustomerModel::find($id);
            $update->kode = $request->inp_kode;
            $update->nama_customer = $request->inp_nama;
            $update->alamat = $request->inp_alamat;
            $update->kota = $request->inp_kota;
            $update->no_telepon = $request->inp_notel;
            $update->level = $request->inp_level;
            $exec = $update->save();
            if($exec)
            {
                return redirect('customer')->with('message', 'Update data berhasil');
            } else {
                return redirect('customer')->with('message', 'Update data gagal');
            }
        } catch (QueryException $e)
        {
            return redirect('customer')->with('message', 'Proses Gagal. Pesan Error : '.$e->getMessage());
        }
    }

    public function delete($id)
    {
        $delete = CustomerModel::find($id);
        $exec = $delete->delete();
        if($exec)
        {
            return redirect('customer')->with('message', 'Data berhasil dihapus');
        } else {
            return redirect('customer')->with('message', 'Data gagal dihapus');
        }
    }

    public function create_no_customer()
    {
        $no_urut = 1;
        $kd="UTB-";
        
        $result = CustomerModel::orderby('id', 'desc')->first();
        if(empty($result->kode)) {
            $no_baru = $kd.sprintf('%04s', $no_urut); 
        } else {
            $no_trans_baru = (int)substr($result->kode, 4, 4) + 1;
            $no_baru = $kd.sprintf('%04s', $no_trans_baru);
        }
        return $no_baru;
    }
}
