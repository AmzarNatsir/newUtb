<?php

namespace App\Http\Controllers;

use App\Models\SupplierModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $query = SupplierModel::all();
        $data['allSupplier'] = $query;
        return view('common.supplier.index', $data);
    }

    public function add()
    {
        return view('common.supplier.add');
    }

    public function store(Request $request)
    {
        try {
            $save = new SupplierModel();
            $save->nama_supplier = $request->inp_nama;
            $save->alamat = $request->inp_alamat;
            $save->email = $request->inp_email;
            $save->no_telepon = $request->inp_notel;
            $save->kontak_person = $request->inp_kontak;
            $exec = $save->save();
            if($exec)
            {
                return redirect('supplier')->with('message', 'Data berhasil disimpan');
            } else {
                return redirect('supplier')->with('message', 'Data gagal disimpan');
            }
        } catch (QueryException $e)
        {
            return redirect('supplier')->with('message', 'Proses gagal. Error : '.$e->getMessage());
        }
    }

    public function edit($id)
    {
        $query = SupplierModel::find($id);
        $data['res'] = $query;
        return view('common.supplier.edit', $data);
    }

    public function update(Request $request, $id)
    {
        try {
            $update = SupplierModel::find($id);
            $update->nama_supplier = $request->inp_nama;
            $update->alamat = $request->inp_alamat;
            $update->email = $request->inp_email;
            $update->no_telepon = $request->inp_notel;
            $update->kontak_person = $request->inp_kontak;
            $exec = $update->save();
            if($exec)
            {
                return redirect('supplier')->with('message', 'Update data berhasil');
            } else {
                return redirect('supplier')->with('message', 'Update data gagal');
            }
        } catch (QueryException $e)
        {
            return redirect('supplier')->with('message', 'Proses Gagal. Pesan Error : '.$e->getMessage());
        }
    }

    public function delete($id)
    {
        $delete = SupplierModel::find($id);
        $exec = $delete->delete();
        if($exec)
        {
            return redirect('supplier')->with('message', 'Data berhasil dihapus');
        } else {
            return redirect('supplier')->with('message', 'Data gagal dihapus');
        }
    }
}
