<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Str;
class EmailController extends Controller
{
    public static function sendMail(Request $request)
    {
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

            $mail->setFrom('', 'Đại học Trà Vinh'); // Thêm địa chỉ email của bạn tại đây

            $mail->addAddress($request->email_request, $request->name_request);
            if ($request) {
                $name_request = $request->name_request;
                $phone_request = $request->phone_request;
                $email_request = $request->email_request;
                $birth = $request->birth;
                $name_city = DB::table('cities')
                    ->select( 'name_city')
                    ->where('id', $request->city_id)
                    ->first();
                $name_major = DB::table('majors')
                    ->select( 'name_major')
                    ->where('id', $request->major_id)
                    ->first();
                $school = $request->school;
                $htmlContent = View::make('user.pages.email-response', compact('name_request', 'phone_request', 'birth', 'name_city', 'name_major', 'school', 'email_request'))->render();
            } else {
                $htmlContent = 'Nội dung email';
            }
            $mail->isHTML(true);
            $mail->Subject = 'Tin nhắn trả lời tự động';
            $mail->Body    = $htmlContent;

            $mail->send();

            return response()->json(['message' => 'Gửi email thành công!']);
        } catch (Exception $e) {
            return response()->json(['error' => "Gửi thất bại: {$mail->ErrorInfo}"]);
        }
    }

    public function sendMailResetPass(Request $request){
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
            $mail->setFrom('', 'Đại học Trà Vinh'); // Thêm địa chỉ email của bạn tại đây

            $mail->addAddress($request->email, '');
            $user = DB::table('users')->where('email', $request->email)->first();
            if ($request && $user) {
                $token = Str::random(60);
                // Xóa token cũ trước khi tạo mới
                DB::table('password_reset_tokens')->where('email', $request->email)->delete();
                DB::table('password_reset_tokens')->insert([
                    'email' => $request->email,
                    'token' => $token,
                ]);
                $htmlContent = View::make('auth.email-forgot-password', compact('token'))->render();
            } else {
                return redirect()->route('user.auth');
            }
            $mail->isHTML(true);
            $mail->Subject = 'Tin nhắn trả lời tự động';
            $mail->Body    = $htmlContent;

            $mail->send();
            
            return redirect()->route('user.auth')->with('success', 'Đã gửi mail đặt lại mật khẩu, vui lòng check email !');
        } catch (Exception $e) {
            return response()->json(['error' => "Gửi thất bại: {$mail->ErrorInfo}"]);
        }
    }
}
