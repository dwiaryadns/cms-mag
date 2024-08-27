<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PromotionController extends Controller
{
    public function index()
    {
        return view('page.admin.promotion.index');
    }

    public function getPromotion(Request $request)
    {
        if ($request->ajax()) {
            $data = Promotion::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('description', function ($row) {
                    $readMore = "";
                    if (strlen($row->description) > 200) {
                        $readMore = '"<i class="read-more" style="cursor:pointer" class="underline" data-id="' . $row->id . '"><u>baca selengkapnya</u></i>';
                    }
                    return \Str::limit(strip_tags($row->description), 200) . $readMore;
                })
                ->rawColumns(['description'])
                ->addColumn('image', function ($row) {
                    return '<img width="200" src="' . url($row->image) . '"/>';
                })
                ->rawColumns(['image'])
                ->addColumn('date', function ($row) {
                    return '<span>' . date('d F Y',strtotime($row->start_date)) . ' s.d ' . date('d F Y',strtotime($row->end_date)) . '</span>';
                })
                ->rawColumns(['date'])
                ->addColumn('action', function ($row) {
                    $actionBtn = '<button data-id="' . $row->id . '" class="edit-promotion btn btn-success btn-sm"><i class="fas fa-edit"></i></button>';
                    $actionBtn .= ' <button data-id="' . $row->id . '" class="delete-promotion btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>';
                    return $actionBtn;
                })
                ->escapeColumns([])
                ->rawColumns(['action'])
                ->make();
        }
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'link_url' => 'nullable',
            'image' => 'required|mimes:jpg,png,jpeg,svg',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'promotion_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('promotion'), $imageName);
            $imagePath = 'promotion/' . $imageName;
        } else {
            $imagePath = Promotion::find($request->id)->image;
        }
        $promotion = Promotion::updateOrCreate(
            ['id' => $request->id],
            [
                'title' => $request->title,
                'author' => $request->author,
                'link_url' => $request->link_url,
                'description' => $request->description,
                'image' => $imagePath,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date
            ]
        );
        return response()->json(['success' => 'Promotion saved successfully.']);
    }
    public function edit($id)
    {
        $promotion = Promotion::find($id);
        return response()->json($promotion);
    }
    public function destroy($id)
    {
        $promotion = Promotion::find($id);
        if ($promotion->image) {
            $imagePath = public_path($promotion->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        $promotion->delete();
        return response()->json(['success' => 'Promotion deleted successfully.']);
    }
}
