<?php

namespace App\Http\Controllers;

use App\Models\MerkModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class MerkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data['allMerk'] = MerkModel::orderby('created_at', 'desc')->get();
        return view('common.merk.index', $data);
    }

    public function add()
    {
        return view('common.merk.add');
    }

    public function store(Request $request)
    {
        try {
            $new_data = new MerkModel();
            $new_data->merk = $request->inp_merk;
            $exec = $new_data->save();
            if($exec)
            {
                return redirect('merk')->with('message', 'Seccess');
            } else {
                return redirect('merk')->with('message', 'Fail');
            }
           
        } catch (QueryException $e)
        {
            return redirect('merk')->with('message', 'Proses Gagal. Pesan Error : '.$e->getMessage());
        }
    }

    public function edit($id)
    {
        $data['res'] = MerkModel::find($id);
        return view('common.merk.edit', $data);
    }

    public function update(Request $request, $id)
    {
        try {
            $update = MerkModel::find($id);
            $update->merk = $request->inp_merk;
            $exec = $update->save();
            if($exec)
            {
                return redirect('merk')->with('message', 'Seccess');
            } else {
                return redirect('merk')->with('message', 'Fail');
            }
        } catch (QueryException $e)
        {
            return redirect('merk')->with('message', 'Proses Gagal. Pesan Error : '.$e->getMessage());
        }
    }

    public function delete($id)
    {
        $delete = MerkModel::find($id);
        $exec = $delete->delete();
        if($exec)
        {
            return redirect('merk')->with('message', 'Delete Seccess');
        } else {
            return redirect('merk')->with('message', 'Delete Fail');
        }
    }
}
