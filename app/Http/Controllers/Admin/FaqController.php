<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FaqController extends Controller
{
    public function index()
    {
        return view('page.admin.faq.index');
    }

    public function getFaq(Request $request)
    {
        if ($request->ajax()) {
            $data = Faq::query()->orderBy('id', 'asc');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<button data-id="' . $row->id . '" class="edit-faq btn btn-success btn-sm"><i class="fas fa-edit"></i></button>';
                    $actionBtn .= ' <button data-id="' . $row->id . '" class="delete-faq btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make();
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required',
            'question' => 'required',
            'answer' => 'required',
            'answer_en' => 'required',
            'question_en' => 'required',
        ]);
        $faq = Faq::updateOrCreate(
            ['id' => $request->id],
            [
                'category' => $request->category,
                'question' => $request->question,
                'answer' => $request->answer,
                'question_en' => $request->question_en,
                'answer_en' => $request->answer_en,
            ]
        );
        return response()->json(['success' => 'FAQ saved successfully.']);
    }
    public function edit($id)
    {
        $faq = Faq::find($id);
        return response()->json($faq);
    }
    public function destroy($id)
    {
        Faq::find($id)->delete();

        return response()->json(['success' => 'FAQ deleted successfully.']);
    }
}
