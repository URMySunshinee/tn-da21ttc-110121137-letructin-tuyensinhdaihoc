<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatAdminController extends Controller
{
    public function index()
    {
        $dataChats = DB::table('chat_ai')
    ->join('users', 'chat_ai.user_id', '=', 'users.id')
    ->select(
        'chat_ai.user_id',
        'users.name',
        DB::raw('MAX(chat_ai.date_message) as last_message_date')
    )
    ->groupBy('chat_ai.user_id', 'users.name')
    ->orderByDesc(DB::raw('MAX(chat_ai.date_message)'))
    ->get();


        return view('admin.pages.chat.index', compact('dataChats'));
    }
    
    public function detailView($id){
    $user_id = $id;

    // Lấy thông tin người dùng từ bảng 'users'
    $user = DB::table('users')->where('id', $user_id)->first();

    // Kiểm tra xem người dùng có tồn tại không
    if (!$user) {
        // Xử lý trường hợp không tìm thấy người dùng,
        // ví dụ: chuyển hướng về trang trước hoặc hiển thị lỗi
        return redirect()->back()->with('error', 'Người dùng không tồn tại.');
    }

    // Truyền user_id và user (bao gồm tên) vào view
    return view('admin.pages.chat.detail', compact('user_id', 'user'));
    }
    
}
