<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MajorController extends Controller
{
    public function reactMajor($id){
        // Lưu giá trị date_updated hiện tại trước khi cập nhật
        $currentMajor = DB::table('majors')->where('id', $id)->first(['date_updated']);
        $currentDateUpdated = $currentMajor ? $currentMajor->date_updated : null;
        
        DB::table('like_major_details')->insert([
                'user_id'         => Auth::user()->id,
                'major_id' => $id,
            ]);
            // Tăng like_major
            DB::statement('UPDATE majors SET like_major = like_major + 1 WHERE id = ?', [$id]);
            
            // Khôi phục date_updated về giá trị ban đầu
            if ($currentDateUpdated) {
                DB::statement("UPDATE majors SET date_updated = ? WHERE id = ?", [$currentDateUpdated, $id]);
            }
            
            $likeMajor = DB::table('majors')
        ->select('like_major')
        ->where('id', $id)
        ->first();
        $data = json_decode($likeMajor->like_major, true);
        return response()->json([
                'like_major' => $data
            ]);
    }
    public function unReactMajor($id){
        // Lưu giá trị date_updated hiện tại trước khi cập nhật
        $currentMajor = DB::table('majors')->where('id', $id)->first(['date_updated']);
        $currentDateUpdated = $currentMajor ? $currentMajor->date_updated : null;
        
        DB::table('like_major_details')
        ->where('major_id', $id)
        ->where('user_id', Auth::user()->id)
        ->delete();
            // Giảm like_major
            DB::statement('UPDATE majors SET like_major = like_major - 1 WHERE id = ?', [$id]);
            
            // Khôi phục date_updated về giá trị ban đầu
            if ($currentDateUpdated) {
                DB::statement("UPDATE majors SET date_updated = ? WHERE id = ?", [$currentDateUpdated, $id]);
            }
            
            $likeMajor = DB::table('majors')
        ->select('like_major')
        ->where('id', $id)
        ->first();
        $data = json_decode($likeMajor->like_major, true);
        return response()->json([
                'like_major' => $data
            ]);
    }
    public function checkLike($id){
         $checkLike = DB::table('like_major_details')
        ->select('*')
        ->where('user_id', Auth::user()->id)
        ->where('major_id', $id)
        ->first();
        if($checkLike){
           return response()->json([
                'check' => true
            ]);
        }
           return response()->json([
                'check' => false
            ]);
    }
}
