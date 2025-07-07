<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MajorAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('majors');
        if ($request->filled('category')) {
            $query->where('category_major_id', $request->category);
        }
        $dataMajor = $query->orderByDesc('id')->paginate(7)->appends($request->query());
        $dataMajorCategory = DB::table('category_major')
            ->select('*')
            ->where('status_category_major', 0)
            ->get();
        $subjectCombinations = DB::table('subject_combinations')
            ->where('is_active', true)
            ->orderBy('priority_order')
            ->orderBy('code')
            ->get();
        return view('admin.pages.major.index', compact('dataMajor','dataMajorCategory', 'subjectCombinations'));
    }

    public function createMajor(Request $request)
    {
        // Validation
        $request->validate([
            'name_major' => 'required|string|max:255',
            'description_major' => 'required|string|max:255',
            'content_major' => 'required|string',
            'category_major_id' => 'required|exists:category_major,id',
            'major_code' => 'nullable|string|max:20',
            'admission_quota' => 'nullable|integer|min:1',
            'training_duration' => 'nullable|numeric|min:1|max:10',
            'degree_level' => 'nullable|string|max:255',
        ]);
        
        // Kiểm tra tên ngành đã tồn tại chưa (không phân biệt hoa thường)
        $nameExists = DB::table('majors')
            ->whereRaw('LOWER(name_major) = ?', [strtolower($request->name_major)])
            ->exists();
            
        if ($nameExists) {
            return back()->withInput()->with('error', 'Tên ngành học này đã tồn tại!');
        }
        
        // Kiểm tra mã ngành đã tồn tại chưa (nếu người dùng nhập mã ngành)
        if ($request->filled('major_code')) {
            $codeExists = DB::table('majors')
                ->whereRaw('LOWER(major_code) = ?', [strtolower($request->major_code)])
                ->exists();
                
            if ($codeExists) {
                return back()->withInput()->with('error', 'Mã ngành này đã tồn tại!');
            }
        }

        $insertData = [
            'name_major' => $request->name_major,
            'description_major' => $request->description_major,
            'content_major' => $request->content_major,
            'category_major_id' => $request->category_major_id,
            'author_id' => Auth::user()->id,
        ];

        // Thêm các trường mới nếu có dữ liệu
        if ($request->filled('admission_score')) {
            $insertData['admission_score'] = $request->admission_score;
        }
        if ($request->filled('admission_method')) {
            $insertData['admission_method'] = $request->admission_method;
        }
        if ($request->filled('admission_quota')) {
            $insertData['admission_quota'] = $request->admission_quota;
        }
        if ($request->filled('subject_combination')) {
            $insertData['subject_combination'] = $request->subject_combination;
        }
        if ($request->filled('total_credits')) {
            $insertData['total_credits'] = $request->total_credits;
        }
        if ($request->filled('training_duration')) {
            $insertData['training_duration'] = $request->training_duration;
        }
        if ($request->filled('degree_level')) {
            $insertData['degree_level'] = $request->degree_level;
        }
        if ($request->filled('training_mode')) {
            $insertData['training_mode'] = $request->training_mode;
        }
        if ($request->filled('career_opportunities')) {
            $insertData['career_opportunities'] = $request->career_opportunities;
        }
        if ($request->filled('average_salary_range')) {
            $insertData['average_salary_range'] = $request->average_salary_range;
        }
        if ($request->filled('job_positions')) {
            $insertData['job_positions'] = $request->job_positions;
        }
        if ($request->filled('contact_email')) {
            $insertData['contact_email'] = $request->contact_email;
        }
        if ($request->filled('contact_phone')) {
            $insertData['contact_phone'] = $request->contact_phone;
        }
        if ($request->filled('office_address')) {
            $insertData['office_address'] = $request->office_address;
        }
        if ($request->filled('website_url')) {
            $insertData['website_url'] = $request->website_url;
        }
        if ($request->filled('video_url')) {
            $insertData['video_url'] = $request->video_url;
        }
        if ($request->filled('brochure_url')) {
            $insertData['brochure_url'] = $request->brochure_url;
        }
        if ($request->filled('special_requirements')) {
            $insertData['special_requirements'] = $request->special_requirements;
        }
        if ($request->filled('facilities')) {
            $insertData['facilities'] = $request->facilities;
        }
        if ($request->filled('notable_achievements')) {
            $insertData['notable_achievements'] = $request->notable_achievements;
        }
        if ($request->has('is_featured')) {
            $insertData['is_featured'] = $request->boolean('is_featured');
        }
        if ($request->filled('priority_order')) {
            $insertData['priority_order'] = $request->priority_order;
        }
        if ($request->filled('major_code')) {
            $insertData['major_code'] = $request->major_code;
        }
        if ($request->filled('job_opportunities')) {
            $insertData['job_opportunities'] = $request->job_opportunities;
        }
        if ($request->filled('post_graduation_opportunities')) {
            $insertData['post_graduation_opportunities'] = $request->post_graduation_opportunities;
        }
        if ($request->filled('contact_info')) {
            $insertData['contact_info'] = $request->contact_info;
        }

        $majorId = DB::table('majors')->insertGetId($insertData);

        // Lưu phương thức xét tuyển nếu có
        if ($request->has('admission_methods')) {
            $admissionMethods = $request->input('admission_methods', []);
            if (is_array($admissionMethods)) {
                $admissionMethodData = [];
                foreach ($admissionMethods as $methodId) {
                    $admissionMethodData[] = [
                        'major_id' => $majorId,
                        'admission_method_id' => $methodId,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }

                if (!empty($admissionMethodData)) {
                    DB::table('major_admission_methods')->insert($admissionMethodData);
                }
            }
        }

        // Lưu tổ hợp môn cho từng phương thức xét tuyển
        if ($request->has('subject_combinations')) {
            $subjectCombinations = $request->input('subject_combinations', []);
            foreach ($subjectCombinations as $methodId => $combinationIds) {
                if (is_array($combinationIds)) {
                    $combinationData = [];
                    foreach ($combinationIds as $combinationId) {
                        $combinationData[] = [
                            'major_id' => $majorId,
                            'admission_method_id' => $methodId,
                            'subject_combination_id' => $combinationId,
                            'created_at' => now(),
                            'updated_at' => now()
                        ];
                    }

                    if (!empty($combinationData)) {
                        DB::table('major_subject_combinations')->insert($combinationData);
                    }
                }
            }
        }

        // Lưu điểm chuẩn nếu có
        if ($request->has('scores')) {
            $scores = $request->input('scores', []);
            $scoreData = [];
            foreach ($scores as $methodId => $yearScores) {
                foreach ($yearScores as $year => $score) {
                    if (!empty($score)) {
                        $scoreData[] = [
                            'major_id' => $majorId,
                            'admission_method_id' => $methodId,
                            'subject_combination_id' => null,
                            'year' => $year,
                            'score' => $score,
                            'created_at' => now(),
                            'updated_at' => now()
                        ];
                    }
                }
            }

            if (!empty($scoreData)) {
                DB::table('admission_scores')->insert($scoreData);
            }
        }

        // Lưu tổ hợp môn nếu có (từ form: subject_combinations[methodId][])
        if ($request->has('subject_combinations')) {
            $subjectCombinations = $request->input('subject_combinations', []);
            $subjectCombinationData = [];
            $allCombinationIds = [];

            // Lấy tất cả combination IDs từ các phương thức
            foreach ($subjectCombinations as $methodId => $combinationIds) {
                if (is_array($combinationIds)) {
                    $allCombinationIds = array_merge($allCombinationIds, $combinationIds);
                }
            }

            // Loại bỏ duplicate IDs
            $allCombinationIds = array_unique($allCombinationIds);

            foreach ($allCombinationIds as $combinationId) {
                $subjectCombinationData[] = [
                    'major_id' => $majorId,
                    'subject_combination_id' => $combinationId,
                    'min_score' => null,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            if (!empty($subjectCombinationData)) {
                DB::table('major_subject_combinations')->insert($subjectCombinationData);
            }
        }

        return back()->with('success', 'Ngành học đã được thêm thành công!');
    }

    public function updateView($id)
    {
        $dataMajor = DB::table('majors')
            ->where('id', $id)
            ->first();

        $dataMajorCategory = DB::table('category_major')
            ->select('*')
            ->where('status_category_major', 0)
            ->get();

        $admissionMethods = DB::table('admission_methods')
            ->where('is_active', true)
            ->orderBy('priority_order')
            ->get();

        $subjectCombinations = DB::table('subject_combinations')
            ->where('is_active', true)
            ->orderBy('priority_order')
            ->orderBy('code')
            ->get();

        return view('admin.pages.major.update', compact('dataMajor','dataMajorCategory', 'admissionMethods', 'subjectCombinations'));
    }

    public function updateMajor(Request $request, $id)
    {
        // Validation
        $request->validate([
            'name_major' => 'required|string|max:255',
            'description_major' => 'required|string|max:255',
            'content_major' => 'required|string',
            'category_major_id' => 'required|exists:category_major,id',
            'major_code' => 'nullable|string|max:20',
            'admission_quota' => 'nullable|integer|min:1',
            'training_duration' => 'nullable|numeric|min:1|max:10',
            'degree_level' => 'nullable|string|max:255',
        ]);
        
        // Lấy dữ liệu ngành hiện tại
        $currentMajor = DB::table('majors')->where('id', $id)->first();
        
        if (!$currentMajor) {
            return redirect()->route('admin.major')->with('error', 'Ngành học không tồn tại.');
        }
        
        // Kiểm tra nếu tên ngành thay đổi thì mới cần kiểm tra trùng lặp
        if (strtolower($currentMajor->name_major) !== strtolower($request->name_major)) {
            // Kiểm tra tên ngành đã tồn tại chưa (không phân biệt hoa thường)
            $nameExists = DB::table('majors')
                ->whereRaw('LOWER(name_major) = ?', [strtolower($request->name_major)])
                ->where('id', '!=', $id)
                ->exists();
                
            if ($nameExists) {
                return back()->withInput()->with('error', 'Tên ngành học này đã tồn tại!');
            }
        }
        
        // Kiểm tra mã ngành có bị trùng không (nếu người dùng nhập mã ngành)
        if ($request->filled('major_code')) {
            // Chỉ kiểm tra nếu mã ngành thay đổi hoặc trước đó không có mã ngành
            $currentCode = $currentMajor->major_code ?? '';
            if (strtolower($currentCode) !== strtolower($request->major_code)) {
                $codeExists = DB::table('majors')
                    ->whereRaw('LOWER(major_code) = ?', [strtolower($request->major_code)])
                    ->where('id', '!=', $id)
                    ->exists();
                    
                if ($codeExists) {
                    return back()->withInput()->with('error', 'Mã ngành này đã tồn tại!');
                }
            }
        }
        // if ($request->image_major1 != '') {
        //     $request->validate([
        //         'image_major1' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        //     ]);

        //     $path = '';

        //     if ($request->hasFile('image_major1')) {
        //         $file = $request->file('image_major1');
        //         $filename = time() . '_' . $file->getClientOriginalName();
        //         $file->move(public_path('imagesSource'), $filename);
        //         $path = '/imagesSource/' . $filename;
        //     }
        // } else if ($request->image_major2 != '') {
        //     $path = $request->image_major2;
        // } else {
        //     $dataMajor = DB::table('majors')->select('image_major')->where('id', $id)->first();
        //     $path = $dataMajor->image_major;
        // }

        $updateData = [
            'name_major' => $request->name_major,
            'description_major' => $request->description_major ?? '', // Đặt giá trị mặc định là chuỗi rỗng
            'content_major' => $request->content_major,
            'category_major_id' => $request->category_major_id,
        ];

        // Thêm các trường mới theo yêu cầu
        $newFields = [
            'major_code', 'admission_quota', 'training_duration', 'degree_level',
            'introduction', 'job_opportunities', 'post_graduation_opportunities', 'contact_info'
        ];

        foreach ($newFields as $field) {
            if ($request->filled($field)) {
                $updateData[$field] = $request->$field;
            }
        }

        DB::table('majors')
            ->where('id', $id)
            ->update($updateData);

        // Cập nhật phương thức xét tuyển
        if ($request->has('admission_methods')) {
            // Xóa phương thức xét tuyển cũ
            DB::table('major_admission_methods')->where('major_id', $id)->delete();

            // Thêm phương thức xét tuyển mới
            $admissionMethods = $request->input('admission_methods', []);
            $admissionMethodData = [];
            foreach ($admissionMethods as $methodId) {
                $admissionMethodData[] = [
                    'major_id' => $id,
                    'admission_method_id' => $methodId,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            if (!empty($admissionMethodData)) {
                DB::table('major_admission_methods')->insert($admissionMethodData);
            }
        }

        // Cập nhật điểm chuẩn
        if ($request->has('scores')) {
            // Xóa điểm chuẩn cũ
            DB::table('admission_scores')->where('major_id', $id)->delete();

            // Thêm điểm chuẩn mới (đơn giản hóa - không phân chia theo tổ hợp môn)
            $scores = $request->input('scores', []);
            $scoreData = [];
            foreach ($scores as $methodId => $yearScores) {
                foreach ($yearScores as $year => $score) {
                    if (!empty($score)) {
                        $scoreData[] = [
                            'major_id' => $id,
                            'admission_method_id' => $methodId,
                            'subject_combination_id' => null, // Không phân chia theo tổ hợp môn
                            'year' => $year,
                            'score' => $score,
                            'created_at' => now(),
                            'updated_at' => now()
                        ];
                    }
                }
            }

            if (!empty($scoreData)) {
                DB::table('admission_scores')->insert($scoreData);
            }
        }

        // Cập nhật tổ hợp môn
        // Xóa tổ hợp môn cũ trước
        DB::table('major_subject_combinations')->where('major_id', $id)->delete();

        // Lưu tổ hợp môn nếu có phương thức yêu cầu tổ hợp môn được chọn
        $hasMethodRequiringCombinations = false;
        if ($request->has('admission_methods')) {
            $admissionMethods = $request->input('admission_methods', []);
            $methodsRequiringCombinations = DB::table('admission_methods')
                ->whereIn('id', $admissionMethods)
                ->where('requires_subject_combinations', true)
                ->exists();
            $hasMethodRequiringCombinations = $methodsRequiringCombinations;
        }

        if ($hasMethodRequiringCombinations && $request->has('subject_combinations')) {
            $subjectCombinations = $request->input('subject_combinations', []);
            $subjectCombinationData = [];

            // Xử lý cả hai trường hợp: subject_combinations[] và subject_combinations[methodId][]
            if (is_array($subjectCombinations)) {
                $firstValue = reset($subjectCombinations);

                if (is_array($firstValue)) {
                    // Trường hợp: subject_combinations[methodId][] (từ form với phương thức riêng biệt)
                    foreach ($subjectCombinations as $methodId => $combinationIds) {
                        if (is_array($combinationIds)) {
                            foreach ($combinationIds as $combinationId) {
                                $subjectCombinationData[] = [
                                    'major_id' => $id,
                                    'admission_method_id' => $methodId,
                                    'subject_combination_id' => $combinationId,
                                    'min_score' => null,
                                    'created_at' => now(),
                                    'updated_at' => now()
                                ];
                            }
                        }
                    }
                } else {
                    // Trường hợp: subject_combinations[] (từ form update cũ - cần xử lý đặc biệt)
                    // Lấy phương thức đầu tiên có requires_subject_combinations = 1
                    $firstMethodId = null;
                    if ($request->has('admission_methods')) {
                        $admissionMethods = $request->input('admission_methods', []);
                        $firstMethod = DB::table('admission_methods')
                            ->whereIn('id', $admissionMethods)
                            ->where('requires_subject_combinations', true)
                            ->first();
                        if ($firstMethod) {
                            $firstMethodId = $firstMethod->id;
                        }
                    }

                    if ($firstMethodId) {
                        foreach ($subjectCombinations as $combinationId) {
                            $subjectCombinationData[] = [
                                'major_id' => $id,
                                'admission_method_id' => $firstMethodId,
                                'subject_combination_id' => $combinationId,
                                'min_score' => null,
                                'created_at' => now(),
                                'updated_at' => now()
                            ];
                        }
                    }
                }

                if (!empty($subjectCombinationData)) {
                    DB::table('major_subject_combinations')->insert($subjectCombinationData);
                }
            }
        }

        return redirect()->route('admin.major')->with('success', 'Ngành học đã được cập nhật thành công!');
    }

    public function softDeleteMajor($id)
    {
        DB::table('majors')
            ->where('id', $id)
            ->update(['status_major' => 1]);

        return back()->with('success', 'Vô hiệu hóa ngành học thành công!');
    }

    public function restoreMajor($id)
    {
        DB::table('majors')
            ->where('id', $id)
            ->update(['status_major' => 0]);

        return back()->with('success', 'Khôi phục ngành học thành công!');
    }

    public function getMajorByIdCategory($id)
    {
        // Lấy thông tin tên khối ngành (nếu id > 0)
        $categoryName = null;
        if ($id > 0) {
            $category = DB::table('category_major')
                ->where('id', $id)
                ->where('status_category_major', 0)
                ->first();
            
            if ($category) {
                $categoryName = $category->name_category_major;
            }
        }
        
        if($id == 0){
            $dataMajor = DB::table('majors')
            ->where('status_major', 0)
            ->get();
        }else{
            $dataMajor = DB::table('majors')
            ->where('category_major_id', $id)
            ->where('status_major', 0)
            ->get();
        }
        
        // Đảm bảo luôn trả về mảng, ngay cả khi không có ngành học nào
        if ($dataMajor->isEmpty()) {
            $dataMajor = collect([]);
        }

        return response()->json([
                'dataMajor' => $dataMajor,
                'categoryName' => $categoryName
            ]);
    }

    // API Methods for Admission System
    public function getActiveAdmissionMethods()
    {
        $methods = DB::table('admission_methods')
            ->where('is_active', true)
            ->orderBy('priority_order')
            ->get();

        return response()->json($methods);
    }

    public function getMajorAdmissionMethods($majorId)
    {
        $methods = DB::table('major_admission_methods')
            ->join('admission_methods', 'major_admission_methods.admission_method_id', '=', 'admission_methods.id')
            ->where('major_admission_methods.major_id', $majorId)
            ->select('admission_methods.*')
            ->get();

        return response()->json($methods);
    }

    public function getMajorAdmissionScores($majorId)
    {
        $scores = DB::table('admission_scores')
            ->where('major_id', $majorId)
            ->get();

        return response()->json($scores);
    }
}
