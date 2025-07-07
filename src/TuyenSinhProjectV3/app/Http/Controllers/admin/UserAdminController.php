<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('users')
            ->select('*')
            ->where('role', '!=', 1);

        // Tìm kiếm theo tên hoặc email
        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function($q) use ($keyword) {
                $q->where('name', 'like', "%$keyword%")
                  ->orWhere('email', 'like', "%$keyword%") ;
            });
        }

        $dataUsers = $query->orderByDesc('created_at')->paginate(20);
        // Giữ lại tham số tìm kiếm khi chuyển trang
        $dataUsers->appends($request->all());

        return view('admin.pages.user.index', compact('dataUsers'));
    }


    public function softDeleteUser($id)
    {
        DB::table('users')
            ->where('id', $id)
            ->update(['status_user' => 1]);

        return back()->with('success', 'Xóa user thành công');
    }

    public function restoreUser($id)
    {
        DB::table('users')
            ->where('id', $id)
            ->update(['status_user' => 0]);

        return back()->with('success', 'Phục hồi user thành công');
    }
}
