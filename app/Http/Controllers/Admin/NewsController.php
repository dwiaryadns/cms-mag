<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Str;

class NewsController extends Controller
{
    public function index()
    {
        return view('page.admin.news.index');
    }

    public function getNews(Request $request)
    {
        if ($request->ajax()) {
            $data = News::query()->orderBy('id', 'asc');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('description', function ($row) {
                    if (strlen($row->description) >= 200) {
                        return \Str::limit(strip_tags($row->description), 200) . '"<i class="read-more" style="cursor:pointer" class="underline" data-id="' . $row->id . '"><u>baca selengkapnya</u></i>';
                    }
                    return strip_tags($row->description);
                })
                ->rawColumns(['description'])
                ->addColumn('image', function ($row) {
                    return '<img width="200" src="' . url($row->image) . '"/>';
                })
                ->rawColumns(['image'])
                ->addColumn('action', function ($row) {
                    $actionBtn = '<button data-id="' . $row->id . '" class="edit-news btn btn-success btn-sm"><i class="fas fa-edit"></i></button>';
                    $actionBtn .= ' <button data-id="' . $row->id . '" class="delete-news btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>';
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
            'title'=> 'required',
            'author'=> 'required',
            'link_url'=> 'nullable',
            'image'=> 'required|mimes:jpg,png,jpeg,svg',
            'description'=> 'required'
        ]);
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'news_'.time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('news'), $imageName);
            $imagePath = 'news/' . $imageName; 
        } else {
            $imagePath = News::find($request->id)->image;
        }
        Log::info($request->all);
        $news = News::updateOrCreate(
            ['id' => $request->id],
            [
                'title' => $request->title,
                'author' => $request->author,
                'link_url' => $request->link_url,
                'description' => $request->description,
                'image' => $imagePath 
            ]
        );
        return response()->json(['success' => 'News saved successfully.']);
    }
    public function edit($id)
    {
        $news = News::find($id);
        return response()->json($news);
    }
    public function destroy($id)
    {
        $news = News::find($id);
        if ($news->image) {
            $imagePath = public_path($news->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        $news->delete();
        return response()->json(['success' => 'News deleted successfully.']);
    }
}
