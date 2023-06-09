<?php

namespace App\Http\Controllers;

use App\Models\ViaModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ViaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data['allData'] = ViaModel::orderby('created_at', 'desc')->get();
        return view('common.via.index', $data);
    }

    public function add()
    {
        return view('common.via.add');
    }

    public function store(Request $request)
    {
        try {
            $new_data = new ViaModel();
            $new_data->penerimaan = $request->inp_nama;
            $exec = $new_data->save();
            if($exec)
            {
                return redirect('via')->with('message', 'Data berhasil disimpan');
            } else {
                return redirect('via')->with('message', 'Data gagal disimpan');
            }
           
        } catch (QueryException $e)
        {
            return redirect('via')->with('message', 'Proses Gagal. Pesan Error : '.$e->getMessage());
        }
    }

    public function edit($id)
    {
        $data['res'] = ViaModel::find($id);
        return view('common.via.edit', $data);
    }

    public function update(Request $request, $id)
    {
        try {
            $update = ViaModel::find($id);
            $update->penerimaan = $request->inp_nama;
            $exec = $update->save();
            if($exec)
            {
                return redirect('via')->with('message', 'Perubahan data berhasil disimpan');
            } else {
                return redirect('via')->with('message', 'Perubahan data gagal disimpan');
            }
        } catch (QueryException $e)
        {
            return redirect('via')->with('message', 'Proses Gagal. Pesan Error : '.$e->getMessage());
        }
    }

    public function delete($id)
    {
        $delete = ViaModel::find($id);
        $exec = $delete->delete();
        if($exec)
        {
            return redirect('via')->with('message', 'Data berhasil dihapus');
        } else {
            return redirect('via')->with('message', 'Data gagal dihapus');
        }
    }
}
