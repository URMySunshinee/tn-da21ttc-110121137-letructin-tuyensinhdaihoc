<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionAdminController extends Controller
{
    public function index(Request $request)
    {
        $majors = DB::table('majors')
            ->whereIn('id', function($query) {
                $query->select('major_id')
                    ->from('question_request')
                    ->distinct();
            })
            ->select('id', 'name_major')
            ->orderBy('name_major')
            ->get();
        $queryPending = DB::table('question_request')
            ->join('cities', 'question_request.city_id', '=', 'cities.id')
            ->join('majors', 'question_request.major_id', '=', 'majors.id')
            ->select('question_request.*','cities.name_city','majors.name_major')
            ->where('status_request', 0)
            ->orderBy('question_request.date_request', 'asc');
        $queryDone = DB::table('question_request')
            ->join('cities', 'question_request.city_id', '=', 'cities.id')
            ->join('majors', 'question_request.major_id', '=', 'majors.id')
            ->select('question_request.*','cities.name_city','majors.name_major')
            ->where('status_request', '!=', 0)
            ->orderBy('question_request.date_request', 'asc');
        if ($request->filled('major_id')) {
            $queryPending->where('question_request.major_id', $request->major_id);
            $queryDone->where('question_request.major_id', $request->major_id);
        }
        $dataQuestionsPending = $queryPending->paginate(15, ['*'], 'pending_page')->appends($request->except('pending_page'));
        $dataQuestionsDone = $queryDone->paginate(15, ['*'], 'done_page')->appends($request->except('done_page'));
        return view('admin.pages.question.index', compact('dataQuestionsPending', 'dataQuestionsDone', 'majors'));
    }

    public function softDeleteQuestion($id)
    {
        DB::table('question_request')
            ->where('id', $id)
            ->update(['status_request' => 1]);

        return back()->with('success', 'Xóa câu hỏi thành công');
    }
    public function done(Request $request)
    {
        $majors = DB::table('majors')
            ->whereIn('id', function($query) {
                $query->select('major_id')
                    ->from('question_request')
                    ->distinct();
            })
            ->select('id', 'name_major')
            ->orderBy('name_major')
            ->get();
        $queryDone = DB::table('question_request')
            ->join('cities', 'question_request.city_id', '=', 'cities.id')
            ->join('majors', 'question_request.major_id', '=', 'majors.id')
            ->select('question_request.*','cities.name_city','majors.name_major')
            ->where('status_request', '!=', 0)
            ->orderBy('question_request.date_request', 'asc');
        if ($request->filled('major_id')) {
            $queryDone->where('question_request.major_id', $request->major_id);
        }
        $dataQuestionsDone = $queryDone->paginate(15)->appends($request->except('page'));
        return view('admin.pages.question.done', compact('dataQuestionsDone', 'majors'));
    }
    public function detail($id)
    {
        $question = DB::table('question_request')
            ->join('cities', 'question_request.city_id', '=', 'cities.id')
            ->join('majors', 'question_request.major_id', '=', 'majors.id')
            ->select('question_request.*', 'cities.name_city', 'majors.name_major')
            ->where('question_request.id', $id)
            ->first();
        if (!$question) {
            abort(404);
        }
        return view('admin.pages.question.detail', compact('question'));
    }

    public function complete($id)
    {
        DB::table('question_request')
            ->where('id', $id)
            ->update(['status_request' => 1]);
        return redirect()->route('admin.question')->with('success', 'Đã hoàn thành yêu cầu tư vấn!');
    }
}
