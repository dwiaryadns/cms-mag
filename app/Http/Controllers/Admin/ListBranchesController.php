<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ListBranches;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ListBranchesController extends Controller
{
    public function index()
    {
        return view('page.admin.list-branches.index');
    }

    public function getListBranches(Request $request)
    {
        if ($request->ajax()) {
            $data = ListBranches::query()->orderBy('id', 'asc');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('contact', function ($row) {
                    $html = 'T : ' . $row->telp . '<br>';
                    $html .= 'F : ' . $row->fax . '<br>';
                    $html .= 'E : ' . $row->email;
                    return $html;
                })
                ->rawColumns(['contact'])
                ->addColumn('action', function ($row) {
                    $actionBtn = '<button data-id="' . $row->id . '" class="edit-list-branches btn btn-success btn-sm"><i class="fas fa-edit"></i></button>';
                    $actionBtn .= ' <button data-id="' . $row->id . '" class="delete-list-branches btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->escapeColumns([])
                ->make();
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required',
            'domicile' => 'required',
            'telp' => 'required',
            'email' => 'required',
        ]);
        $faq = ListBranches::updateOrCreate(
            ['id' => $request->id],
            [
                'category' => $request->category,
                'address' => $request->address,
                'domicile' => $request->domicile,
                'fax' => $request->fax,
                'telp' => $request->telp,
                'email' => $request->email,
                'lat' => $request->lat,
                'long' => $request->long,
            ]
        );
        return response()->json(['success' => 'List Branches saved successfully.']);
    }
    public function edit($id)
    {
        $faq = ListBranches::find($id);
        return response()->json($faq);
    }
    public function destroy($id)
    {
        ListBranches::find($id)->delete();

        return response()->json(['success' => 'List Branches deleted successfully.']);
    }
}