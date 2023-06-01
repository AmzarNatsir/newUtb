<?php

namespace App\Http\Controllers;

use App\Models\KontainerModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class KontainerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $query = KontainerModel::all();
        $data['allKontainer'] = $query;
        return view('common.kontainer.index', $data);
    }

    public function add()
    {
        return view('common.kontainer.add');
    }

    public function store(Request $request)
    {
        try {
            $save = new KontainerModel();
            $save->nama_kontainer = $request->inp_nama;
            $save->alamat = $request->inp_alamat;
            $save->email = $request->inp_email;
            $save->no_telepon = $request->inp_notel;
            $save->kontak_person = $request->inp_kontak;
            $exec = $save->save();
            if($exec)
            {
                return redirect('kontainer')->with('message', 'Data berhasil disimpan');
            } else {
                return redirect('kontainer')->with('message', 'Data gagal disimpan');
            }
        } catch (QueryException $e)
        {
            return redirect('kontainer')->with('message', 'Proses gagal. Error : '.$e->getMessage());
        }
    }

    public function edit($id)
    {
        $query = KontainerModel::find($id);
        $data['res'] = $query;
        return view('common.kontainer.edit', $data);
    }

    public function update(Request $request, $id)
    {
        try {
            $update = KontainerModel::find($id);
            $update->nama_kontainer = $request->inp_nama;
            $update->alamat = $request->inp_alamat;
            $update->email = $request->inp_email;
            $update->no_telepon = $request->inp_notel;
            $update->kontak_person = $request->inp_kontak;
            $exec = $update->save();
            if($exec)
            {
                return redirect('kontainer')->with('message', 'Update data berhasil');
            } else {
                return redirect('kontainer')->with('message', 'Update data gagal');
            }
        } catch (QueryException $e)
        {
            return redirect('kontainer')->with('message', 'Proses Gagal. Pesan Error : '.$e->getMessage());
        }
    }

    public function delete($id)
    {
        $delete = KontainerModel::find($id);
        $exec = $delete->delete();
        if($exec)
        {
            return redirect('kontainer')->with('message', 'Data berhasil dihapus');
        } else {
            return redirect('kontainer')->with('message', 'Data gagal dihapus');
        }
    }
}
