<?php

namespace App\Http\Controllers;
use App\Http\Controllers\EmailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    public function create(Request $request)
{
    $validated = $request->validate([
        'name_request'   => 'required|string|max:255',
        'phone_request'  => 'required|string|max:255',
        'email_request'  => 'required|email|max:255',
        'birth'          => 'required|date',
        'city_id'        => 'required|integer|exists:cities,id',
        'major_id'       => 'required|integer|exists:majors,id',
        'school'         => 'required|string|max:255',
    ]);

    $id = DB::table('question_request')->insertGetId([
        'name_request'  => $validated['name_request'],
        'phone_request' => $validated['phone_request'],
        'email_request' => $validated['email_request'],
        'birth'         => $validated['birth'],
        'city_id'       => $validated['city_id'],
        'major_id'      => $validated['major_id'],
        'school'        => $validated['school'],
    ]);
    
    EmailController::sendMail($request);

    return redirect()->route('user.home') 
        ->with('success', 'Yêu cầu đã được gửi thành công! Chúng tôi sẽ phản hồi sớm nhất có thể.');
}
}
