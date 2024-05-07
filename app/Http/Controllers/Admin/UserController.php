<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view('page.admin.user.index');
    }
    public function getUser(Request $request)
    {
        if ($request->ajax()) {
            $data = User::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('role', function ($row) {
                    $role = $row->role;
                    return $role;
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('role') == 'admin' || $request->get('role') == 'marketing' || $request->get('role') == 'user') {
                        $instance->where('role', $request->get('role'));
                    }
                    if (!empty($request->get('search'))) {
                        $instance->where(function ($w) use ($request) {
                            $search = $request->get('search');
                            $w->orWhere('role', 'LIKE', "%$search%")
                                ->orWhere('name', 'LIKE', "%$search%")
                                ->orWhere('email', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['role'])
                ->addColumn('action', function ($row) {
                    $actionBtn = '<button data-id="' . $row->id . '" class="edit-user btn btn-success btn-sm"><i class="fas fa-edit"></i></button>';
                    $actionBtn .= ' <button data-id="' . $row->id . '" class="delete-user btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make();
        }
    }
    public function store(Request $request)
    {
        $user = User::updateOrCreate(
            ['id' => $request->id],
            [
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'password' => bcrypt($request->password),
            ]
        );
        return response()->json(['success' => 'User saved successfully.']);
    }
    public function edit($id)
    {
        $promotion = User::find($id);
        return response()->json($promotion);
    }
    public function destroy($id)
    {
        User::find($id)->delete();
        return response()->json(['success' => 'User deleted successfully.']);
    }
}