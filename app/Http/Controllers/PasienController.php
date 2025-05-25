<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\RekamMedis;
use App\Models\Product;
use DB, DataTables, Auth;

class PasienController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Patient::select(['id', 'name', 'email', 'phone', 'no_identity', 'registered_at', 'created_at']) 
                ->active()
                ->orderBy('created_at', 'desc');

            return DataTables::of($data)
                ->addIndexColumn()
                // ->addColumn('ktp', function($row) {
                //     return $row->ktp ? $row->ktp : '-';
                // })
                ->addColumn('action', function($row){
                    $editUrl = route('pasien.edit', $row->id);
                    $deleteUrl = route('pasien.destroy', $row->id);
                    $showUrl = route('pasien.rekam-medis', $row->id);
                    $role = Auth::user()->getRole()->slug;
                    $btn = '';
                    if($role == 'admin' || $role == 'registrasi') { 
                        $btn .= '<a href="'.$editUrl.'" class="btn btn-icon btn-warning btn-sm me-1 mr-2" title="Edit">
                                    <span class="svg-icon svg-icon-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.489 4.759L15.647 2.60002C16.061 2.18602 16.689 2.18602 17.103 2.60002L21.4 6.89702C21.814 7.31102 21.814 7.93902 21.4 8.35303Z" fill="currentColor"></path>
                                            <path d="M19.2411 10.511L13.4891 4.75908L2.48908 15.7591C2.16908 16.0791 2.03308 16.5791 2.07908 17.0391L2.69908 21.9291C2.74908 22.3491 3.11908 22.6391 3.53908 22.5091L8.42908 20.9191C8.88908 20.7791 9.28908 20.4391 9.60908 20.1191L19.2411 10.511Z" fill="currentColor"></path>
                                        </svg>
                                    </span>
                                </a>';
    
                        $btn .= '<form action="'.$deleteUrl.'" method="POST" style="display:inline-block;" class="form-delete-'.$row->id.'">
                                    '.csrf_field().'
                                    '.method_field("DELETE").'
                                    <button type="button" onclick="showModalConfirm(\'form-delete-'.$row->id.'\')" class="btn btn-icon btn-danger btn-sm mr-2" title="Delete">
                                        <span class="svg-icon svg-icon-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor"></path>
                                                <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5.5C19 6.05228 18.5523 6.5 18 6.5H6C5.44772 6.5 5 6.05228 5 5.5V5Z" fill="currentColor"></path>
                                                <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4.5C15 5.05228 14.5523 5.5 14 5.5H10C9.44772 5.5 9 5.05228 9 4.5V4Z" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                    </button>
                                </form>';
                    }
                    if($role == 'admin' || $role == 'perawat' || $role == 'dokter') {
                        $btn .= '<a href="'.$showUrl.'" class="btn btn-icon btn-info btn-sm me-1 mr-2" title="Show">
                                    <i class="fas fa-stethoscope"></i></a>';
                    }
                    return $btn;
                })
                ->editColumn('registered_at', function ($row) {
                    return $row->registered_at ? date('d F Y H:i:s', strtotime($row->registered_at)) : '';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    
        return view('pages.pasien.index'); 
    }

    public function create()
    {
        return view('pages.pasien.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|unique:users|email',
            'phone' => 'required',
            'no_identity' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $request['is_active'] = isset($request->is_active) ? true : false;
            $request['date_of_birth'] = isset($request->date_of_birth) ? date('Y-m-d', strtotime($request->date_of_birth)) : null;
            Patient::create($request->all());
            DB::commit();
            return redirect()->route('pasien.index')->with('success', 'Pasien created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $data = Patient::findOrFail($id);
        return view('pages.pasien.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|unique:users|email',
            'phone' => 'required',
            'no_identity' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $request['is_active'] = isset($request->is_active) ? true : false;
            $request['date_of_birth'] = isset($request->date_of_birth) ? date('Y-m-d', strtotime($request->date_of_birth)) : null;
            
            $pasien = Patient::findOrFail($id);
            $pasien->update($request->all());
            DB::commit();
            return redirect()->route('pasien.index')->with('success', 'Pasien updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $pasien = Patient::findOrFail($id);
        $pasien->is_active = false;
        $pasien->update();

        // $pasien->delete();
        return redirect()->route('pasien.index')->with('success', 'Pasien deleted successfully.');
    }

    public function rekamMedis($id)
    {
        $data = Patient::with(['emr', 'emr.obat'])->findOrFail($id);
        $obat = Product::where('stock', '>', 0)->active()->get();
        return view('pages.pasien.detail', compact('data','obat'));
    }


    public function saveEMR($id, Request $request)
    { 
        $role = Auth::user()->getRole()->slug;
        $rules = [];
        switch ($role) {
            case 'admin':
                $rules = [
                    'berat_badan' => 'required',
                    'tekanan_darah' => 'required',
                    'keluhan' => 'required|string|max:2000',
                    'hasil_diagnosa' => 'required|string|max:2000',
                ];
                break;
            case 'perawat':
                $rules = [
                    'berat_badan' => 'required',
                    'tekanan_darah' => 'required|string',
                ];
                break;
            case 'dokter':
                $rules = [
                    'keluhan' => 'required|string|max:2000',
                    'hasil_diagnosa' => 'required|string|max:2000',
                ];
                break;
            
            default:
                $rules = [
                    'berat_badan' => 'required',
                    'tekanan_darah' => 'required',
                    'keluhan' => 'required|string|max:2000',
                    'hasil_diagnosa' => 'required|string|max:2000',
                ];
               break;
        }
        // return $request->all();
        $valid = $request->validate($rules);
        DB::beginTransaction();
        try {
            $emr = RekamMedis::updateOrCreate(
                ['patient_id' => $id],
                $request->all()
            );
            if(isset($request->product_id)) {
                $product = Product::find($request->product_id);
                $product->stock = $product->stock - 1;
                $product->update();
            }
            DB::commit();
            return redirect()->route('pasien.rekam-medis', $id)
            ->with('success', 'Data successfuly saved');
        } catch (\Excepotion $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }

    }
}
