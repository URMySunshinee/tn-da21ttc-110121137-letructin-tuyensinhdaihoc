<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class QuestionReplyController extends Controller
{
    public function reply(Request $request)
    {
        $request->validate([
            'email_request' => 'required|email',
            'name_request' => 'required',
            'subject' => 'required',
            'content' => 'required',
            'id' => 'required|integer',
        ]);

        $mail = new PHPMailer(true);
        try {
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = ''; // Thêm địa chỉ email Gmail của bạn tại đây
            $mail->Password   = ''; // Thêm mật khẩu ứng dụng Gmail tại đây
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;
            $mail->setFrom('', 'TS - Đại học Trà Vinh (TEST)'); // Thêm địa chỉ email của bạn tại đây
            $mail->addAddress($request->email_request, $request->name_request);
            $mail->isHTML(true);
            $mail->Subject = $request->subject;
            $mail->Body    = nl2br($request->content);
            $mail->send();
            // Cập nhật trạng thái yêu cầu tư vấn
            DB::table('question_request')->where('id', $request->id)->update(['status_request' => 1]);
            return redirect()->route('admin.question')->with('success', 'Gửi email đến người dùng thành công!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Gửi email thất bại: ' . $mail->ErrorInfo);
        }
    }
}
