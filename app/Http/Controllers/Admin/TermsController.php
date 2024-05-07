<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Terms;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TermsController extends Controller
{
    public function index()
    {
        return view('page.admin.terms.index');
    }

    public function getTerms(Request $request)
    {
        if ($request->ajax()) {
            $data = Terms::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('description', function ($row) {
                    return   \Str::limit(strip_tags($row->description), 200) . '"<i class="read-more" style="cursor:pointer" class="underline" data-id="' . $row->id . '"><u>baca selengkapnya</u></i>';
                })
                ->escapeColumns([])
                ->addColumn('action', function ($row) {
                    $actionBtn = '<button data-id="' . $row->id . '" class="edit-terms btn btn-success btn-sm"><i class="fas fa-edit"></i></button>';
                    $actionBtn .= ' <button data-id="' . $row->id . '" class="delete-terms btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make();
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'type'=> 'required',
            'description'=> 'required'
        ]);
        $faq = Terms::updateOrCreate(
            ['id' => $request->id],
            [
                'type' => $request->type,
                'description' => $request->description
            ]
        );
        return response()->json(['success' => 'Terms saved successfully.']);
    }
    public function edit($id)
    {
        $faq = Terms::find($id);
        return response()->json($faq);
    }
    public function destroy($id)
    {
        Terms::find($id)->delete();
        return response()->json(['success' => 'Terms deleted successfully.']);
    }
}