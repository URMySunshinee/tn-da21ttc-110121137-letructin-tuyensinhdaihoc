<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SubjectCombinationController extends Controller
{
    public function index()
    {
        $subjectCombinations = DB::table('subject_combinations')
            ->orderBy('priority_order')
            ->orderBy('code')
            ->get();

        return view('admin.pages.subjectCombination.index', compact('subjectCombinations'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:10|unique:subject_combinations,code',
            'name' => 'required|string|max:255',
            'subjects' => 'required|string',
            'description' => 'nullable|string',
            'priority_order' => 'nullable|integer|min:0'
        ]);

        DB::table('subject_combinations')->insert([
            'code' => strtoupper($request->code),
            'name' => $request->name,
            'subjects' => $request->subjects,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
            'priority_order' => $request->priority_order ?? 0,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with('success', 'Tổ hợp môn đã được thêm thành công!');
    }

    public function updateView($id)
    {
        $subjectCombination = DB::table('subject_combinations')
            ->where('id', $id)
            ->first();

        if (!$subjectCombination) {
            return redirect()->route('admin.subjectCombination')->with('error', 'Không tìm thấy tổ hợp môn!');
        }

        return view('admin.pages.subjectCombination.update', compact('subjectCombination'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|string|max:10|unique:subject_combinations,code,' . $id,
            'name' => 'required|string|max:255',
            'subjects' => 'required|string',
            'description' => 'nullable|string',
            'priority_order' => 'nullable|integer|min:0'
        ]);

        DB::table('subject_combinations')
            ->where('id', $id)
            ->update([
                'code' => strtoupper($request->code),
                'name' => $request->name,
                'subjects' => $request->subjects,
                'description' => $request->description,
                'is_active' => $request->has('is_active'),
                'priority_order' => $request->priority_order ?? 0,
                'updated_at' => now()
            ]);

        return redirect()->route('admin.subjectCombination')->with('success', 'Tổ hợp môn đã được cập nhật!');
    }

    public function toggleStatus($id)
    {
        $subjectCombination = DB::table('subject_combinations')->where('id', $id)->first();
        
        if (!$subjectCombination) {
            return back()->with('error', 'Không tìm thấy tổ hợp môn!');
        }

        DB::table('subject_combinations')
            ->where('id', $id)
            ->update([
                'is_active' => !$subjectCombination->is_active,
                'updated_at' => now()
            ]);

        $status = $subjectCombination->is_active ? 'vô hiệu hóa' : 'kích hoạt';
        return back()->with('success', "Đã {$status} tổ hợp môn thành công!");
    }

    public function delete($id)
    {
        // Kiểm tra xem có ngành nào đang sử dụng tổ hợp này không
        $isUsed = DB::table('major_subject_combinations')
            ->where('subject_combination_id', $id)
            ->exists();

        if ($isUsed) {
            return back()->with('error', 'Không thể xóa tổ hợp môn này vì đang được sử dụng bởi các ngành học!');
        }

        DB::table('subject_combinations')->where('id', $id)->delete();
        
        return back()->with('success', 'Đã xóa tổ hợp môn thành công!');
    }

    // API để lấy danh sách tổ hợp môn cho dropdown
    public function getActiveSubjectCombinations()
    {
        $combinations = DB::table('subject_combinations')
            ->where('is_active', true)
            ->orderBy('priority_order')
            ->orderBy('code')
            ->get(['id', 'code', 'name', 'subjects']);

        return response()->json($combinations);
    }

    // API để lấy tổ hợp môn của một ngành
    public function getMajorSubjectCombinations($majorId)
    {
        $combinations = DB::table('major_subject_combinations')
            ->join('subject_combinations', 'major_subject_combinations.subject_combination_id', '=', 'subject_combinations.id')
            ->leftJoin('admission_methods', 'major_subject_combinations.admission_method_id', '=', 'admission_methods.id')
            ->where('major_subject_combinations.major_id', $majorId)
            ->select(
                'subject_combinations.*',
                'major_subject_combinations.min_score',
                'major_subject_combinations.admission_method_id',
                'admission_methods.name as admission_method_name'
            )
            ->orderBy('subject_combinations.priority_order')
            ->get();

        return response()->json($combinations);
    }

    // API để lấy tổ hợp môn của một ngành theo phương thức xét tuyển
    public function getMajorSubjectCombinationsByMethod($majorId, $methodId)
    {
        $combinations = DB::table('major_subject_combinations')
            ->join('subject_combinations', 'major_subject_combinations.subject_combination_id', '=', 'subject_combinations.id')
            ->where('major_subject_combinations.major_id', $majorId)
            ->where('major_subject_combinations.admission_method_id', $methodId)
            ->select('subject_combinations.*', 'major_subject_combinations.min_score')
            ->orderBy('subject_combinations.priority_order')
            ->get();

        return response()->json($combinations);
    }
}
