<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Auth không được sử dụng trực tiếp trong code hiện tại, nhưng giữ lại nếu có kế hoạch dùng sau này.
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Import Log facade để ghi lỗi

class MajorCategoryController extends Controller
{
    public function index()
    {
        $dataMajorCategory = DB::table('category_major')
            ->select('*')
            ->get();

        return view('admin.pages.majorCategory.index', compact('dataMajorCategory'));
    }

    public function createMajorCategory(Request $request)
    {
        // Validation của dữ liệu đầu vào
        $request->validate([
            'name_category_major' => 'required|string|max:255',
        ]);

        try {
            // Kiểm tra trùng lặp không phân biệt hoa thường
            $exists = DB::table('category_major')
                ->whereRaw('LOWER(name_category_major) = ?', [strtolower($request->name_category_major)])
                ->exists();
                
            if ($exists) {
                return back()->withInput()->with('error', 'Tên khối ngành này đã tồn tại!');
            }
            
            DB::table('category_major')->insert([
                'name_category_major' => $request->name_category_major,
                'status_category_major' => 0, // Mặc định là 0 (đang hoạt động)
            ]);
            
            return back()->with('success', 'Tạo khối ngành mới thành công!');
        } catch (\Exception $e) {
            Log::error('Lỗi khi tạo khối ngành: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi tạo khối ngành: ' . $e->getMessage());
        }
    }

    public function updateView($id)
    {
        $dataMajorCategory = DB::table('category_major')
            ->select('*')
            ->where('id', $id)
            ->first();

        // Kiểm tra xem khối ngành có tồn tại không
        if (!$dataMajorCategory) {
            return redirect()->route('admin.majorCategory')->with('error', 'Khối ngành không tồn tại.');
        }

        return view('admin.pages.majorCategory.update', compact('dataMajorCategory'));
    }

    public function updateMajorCategory(Request $request, $id)
    {
        // Validation cơ bản
        $request->validate([
            'name_category_major' => 'required|string|max:255',
        ]);

        try {
            // Kiểm tra xem khối ngành có tồn tại trước khi cập nhật
            $existingMajorCategory = DB::table('category_major')->where('id', $id)->first();
            if (!$existingMajorCategory) {
                return redirect()->route('admin.majorCategory')->with('error', 'Khối ngành không tồn tại để cập nhật.');
            }
            
            // Kiểm tra nếu tên không thay đổi thì không cần kiểm tra trùng
            if (strtolower($existingMajorCategory->name_category_major) !== strtolower($request->name_category_major)) {
                // Kiểm tra trùng lặp không phân biệt hoa thường, loại trừ chính bản ghi này
                $exists = DB::table('category_major')
                    ->whereRaw('LOWER(name_category_major) = ?', [strtolower($request->name_category_major)])
                    ->where('id', '!=', $id)
                    ->exists();
                
                if ($exists) {
                    return back()->withInput()->with('error', 'Tên khối ngành này đã tồn tại!');
                }
            }

            $affected = DB::table('category_major')
                ->where('id', $id)
                ->update([
                    'name_category_major' => $request->name_category_major,
                ]);

            if ($affected) {
                return redirect()->route('admin.majorCategory')->with('success', 'Cập nhật khối ngành thành công!');
            } else {
                // Trường hợp không có gì thay đổi
                return redirect()->route('admin.majorCategory')->with('info', 'Không có thay đổi nào được thực hiện.');
            }

        } catch (\Exception $e) {
            Log::error('Lỗi khi cập nhật khối ngành: ' . $e->getMessage());
            return redirect()->route('admin.majorCategory')->with('error', 'Có lỗi xảy ra khi cập nhật khối ngành: ' . $e->getMessage());
        }
    }

    public function softDeleteMajorCategory($id)
    {
        try {
            // Kiểm tra xem khối ngành có tồn tại trước khi xóa mềm
            $existingMajorCategory = DB::table('category_major')->where('id', $id)->first();
            if (!$existingMajorCategory) {
                return back()->with('error', 'Khối ngành không tồn tại để vô hiệu hóa.');
            }

            $affected = DB::table('category_major')
                ->where('id', $id)
                ->update(['status_category_major' => 1]);

            if ($affected) {
                return back()->with('success', 'Vô hiệu hóa khối ngành thành công!');
            } else {
                // Trường hợp đã ở trạng thái deleted hoặc không tìm thấy
                return back()->with('info', 'Khối ngành đã ở trạng thái đã xóa hoặc không tìm thấy.');
            }
        } catch (\Exception $e) {
            Log::error('Lỗi khi xóa mềm khối ngành: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi xóa mềm khối ngành: ' . $e->getMessage());
        }
    }

    public function restoreMajorCategory($id)
    {
        try {
            // Kiểm tra xem khối ngành có tồn tại trước khi khôi phục
            $existingMajorCategory = DB::table('category_major')->where('id', $id)->first();
            if (!$existingMajorCategory) {
                return back()->with('error', 'Khối ngành không tồn tại để khôi phục.');
            }

            $affected = DB::table('category_major')
                ->where('id', $id)
                ->update(['status_category_major' => 0]);

            if ($affected) {
                return back()->with('success', 'Đã khôi phục khối ngành thành công!');
            } else {
                // Trường hợp đã ở trạng thái restored hoặc không tìm thấy
                return back()->with('info', 'Khối ngành đã ở trạng thái hoạt động hoặc không tìm thấy.');
            }
        } catch (\Exception $e) {
            Log::error('Lỗi khi khôi phục khối ngành: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi khôi phục khối ngành: ' . $e->getMessage());
        }
    }
}