<?php

namespace App\Http\Controllers;

use App\Models\UnitModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data['allUnit'] = UnitModel::orderby('created_at', 'desc')->get();
        return view('common.unit.index', $data);
    }

    public function add()
    {
        return view('common.unit.add');
    }

    public function store(Request $request)
    {
        try {
            $new_data = new UnitModel();
            $new_data->unit = $request->inp_unit;
            $exec = $new_data->save();
            if($exec)
            {
                return redirect('unit')->with('message', 'Seccess');
            } else {
                return redirect('unit')->with('message', 'Fail');
            }
           
        } catch (QueryException $e)
        {
            return redirect('unit')->with('message', 'Proses Gagal. Pesan Error : '.$e->getMessage());
        }
    }

    public function edit($id)
    {
        $data['res'] = UnitModel::find($id);
        return view('common.unit.edit', $data);
    }

    public function update(Request $request, $id)
    {
        try {
            $update = UnitModel::find($id);
            $update->unit = $request->inp_unit;
            $exec = $update->save();
            if($exec)
            {
                return redirect('unit')->with('message', 'Seccess');
            } else {
                return redirect('unit')->with('message', 'Fail');
            }
        } catch (QueryException $e)
        {
            return redirect('unit')->with('message', 'Proses Gagal. Pesan Error : '.$e->getMessage());
        }
    }

    public function delete($id)
    {
        $delete = UnitModel::find($id);
        $exec = $delete->delete();
        if($exec)
        {
            return redirect('unit')->with('message', 'Delete Seccess');
        } else {
            return redirect('unit')->with('message', 'Delete Fail');
        }
    }
}
