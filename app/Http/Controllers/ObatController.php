<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;
use DB, DataTables, Auth;

class ObatController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::with(['category:id,name,slug'])
                ->select(['id', 'name', 'description', 'base_price', 'stock', 'slug', 'category_id']) 
                ->active()
                ->orderBy('created_at', 'desc');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $editUrl = route('obat.edit', $row->slug);
                    $deleteUrl = route('obat.destroy', $row->slug);
                    $role = Auth::user()->getRole()->slug;
                    $btn = '';
                    if($role == 'admin' || $role == 'apoteker') {
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
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    
        return view('pages.obat.index'); 
    }

    public function create()
    {
        $data['category'] = ProductCategory::all();
        return view('pages.obat.create', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'stock' => 'required|numeric',
            'base_price' => 'required|numeric',
            'category_id' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $request['is_active'] = isset($request->is_active) ? true : false;
            Product::create($request->all());
            DB::commit();
            return redirect()->route('obat.index')->with('success', 'Obat created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function edit($slug)
    {
        $data['product'] = Product::where('slug',$slug)->first();
        if(!isset($data['product'])) {
            abort(404);
        }
        $data['category'] = ProductCategory::all();
        return view('pages.obat.edit', compact('data'));
    }

    public function update(Request $request, $slug)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'stock' => 'required|numeric',
            'base_price' => 'required|numeric',
            'category_id' => 'required',
        ]);

        DB::beginTransaction();
        try {
            
            $product = Product::where('slug', $slug)->first();
            if(!isset($product)) {
                abort(404);
            }
            $request['is_active'] = isset($request->is_active) ? true : false;
            $product->update($request->all());
            DB::commit();
            return redirect()->route('obat.index')->with('success', 'Obat updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy($slug)
    {
        $product = Product::where('slug',$slug)->first();
        if(!isset($product)) {
            abort(404);
        }
        $product->is_active = false;
        $product->update();

        return redirect()->route('obat.index')->with('success', 'Obat deleted successfully.');
    }
}
