<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.auth');
    }
    public function changeInfor()
    {
        $userId = Auth::id();
        
        // Lấy danh sách ngành học đã thích
        $likedMajors = DB::table('like_major_details')
            ->join('majors', 'like_major_details.major_id', '=', 'majors.id')
            ->where('like_major_details.user_id', $userId)
            ->select('majors.id', 'majors.name_major', 'majors.description_major', 'like_major_details.date_like')
            ->orderBy('like_major_details.date_like', 'desc')
            ->get();
            
        // Lấy danh sách bài viết đã thích
        $likedBlogs = DB::table('blog_likes')
            ->join('blogs', 'blog_likes.blog_id', '=', 'blogs.id')
            ->where('blog_likes.user_id', $userId)
            ->select('blogs.id', 'blogs.name_blog', 'blogs.image_blog', 'blogs.date_blog', 'blog_likes.created_at')
            ->orderBy('blog_likes.created_at', 'desc')
            ->get();
            
        return view('auth.infor', compact('likedMajors', 'likedBlogs'));
    }
    public function update(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . Auth::user()->id,
            'address'  => 'required|string|max:255',
            'phone'    => 'required|string|max:10',
            'age'      => 'required|integer|min:0',
        ]);

        DB::table('users')->where('id', Auth::user()->id)->update([
            'name'              => $request->name,
            'email'             => $request->email,
            'address'           => $request->address,
            'phone'             => $request->phone,
            'age'               => $request->age,
        ]);
        Auth::loginUsingId(Auth::user()->id);
        return back()->with('success', 'Cập nhật thông tin thành công!');
    }

    public function changePassword()
    {
        return view('auth.change-password');
    }
    public function changePassword_(Request $request)
    {
        $user = DB::table('users')->where('id', Auth::user()->id)->first();

        if ($user && Hash::check($request->old_password, $user->password) && $request->password == $request->confirmPassword) {
            DB::table('users')->where('id', Auth::user()->id)->update([
                'password' => Hash::make($request->password),
            ]);
            return back()->with('success', 'Đổi mật khẩu thành công!');
        }
        return back()->with('error', 'Đổi mật khẩu thất bại!');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'address'  => 'required|string|max:255',
            'phone'    => 'required|string|max:10',
            'age'      => 'required|integer|min:0',
        ]);

        $userId = DB::table('users')->insertGetId([
            'name'              => $request->name,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'address'           => $request->address,
            'phone'             => $request->phone,
            'age'               => $request->age,
            'role'              => 0,
            'created_at'        => now(),
        ]);
        Auth::loginUsingId($userId);
        return redirect()->route('user.home')->with('success', 'Đăng ký thành công. Chào mừng bạn đến với hệ thống tuyển sinh TVU!');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $user = DB::table('users')
            ->where('email', $credentials['email'])
            ->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email hoặc mật khẩu không đúng']);
        }
        if ($user->status_user != 0) {
            return back()->withErrors(['email' => 'Tài khoản của bạn đã bị vô hiệu hóa. Vui lòng liên hệ quản trị viên!']);
        }
        if (Hash::check($credentials['password'], $user->password)) {
            Auth::loginUsingId($user->id);
            if (Auth::user()->role == 0) {
                return redirect()->route('user.home');
            } else if (Auth::user()->role == 1) {
                return redirect()->route('admin.home');
            }
        }
        return back()->withErrors(['email' => 'Email hoặc mật khẩu không đúng']);
    }
    public function resetPassword($token)
    {
        $checkToken = DB::table('password_reset_tokens')
            ->select('*')
            ->where('token', $token)
            ->first();
        if ($checkToken) {
            return view('auth.reset-password');
        } else {
            return redirect()->route('user.auth')->with ('error', 'Token không hợp lệ hoặc đã hết hạn!');
        }
    }
    public function resetPassword_(Request $request, $token)
    {
        $checkToken = DB::table('password_reset_tokens')
            ->select('*')
            ->where('token', $token)
            ->first();
        if ($checkToken && $request->password == $request->confirmPassword) {
            DB::table('users')->where('email', $checkToken->email)->update([
                'password' => Hash::make($request->password),
            ]);
            return redirect()->route('user.auth')->with('success', 'Đặt lại mật khẩu thành công! Bạn có thể đăng nhập lại bằng mật khẩu mới.');
        } else {
            return back()->with('error', 'Đổi mật khẩu thất bại!');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('user.auth');
    }

    /**
     * Redirect to Google for authentication
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle callback from Google
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            return redirect()->route('user.auth')->withErrors(['email' => 'Không thể đăng nhập bằng Google.']);
        }
        $user = \DB::table('users')->where('email', $googleUser->getEmail())->first();
        if (!$user) {
            // Đăng ký mới nếu chưa có user
            $userId = \DB::table('users')->insertGetId([
                'name' => $googleUser->getName() ?? $googleUser->getNickname() ?? 'Google User',
                'email' => $googleUser->getEmail(),
                'password' => '',
                'address' => '',
                'phone' => '',
                'age' => 0,
                'role' => 0,
                'created_at' => now(),
            ]);
            $user = \DB::table('users')->where('id', $userId)->first();
        }
        if ($user->status_user != 0) {
            return redirect()->route('user.auth')->withErrors(['email' => 'Tài khoản của bạn đã bị vô hiệu hóa. Vui lòng liên hệ quản trị viên!']);
        }
        \Auth::loginUsingId($user->id);
        if ($user->role == 0) {
            return redirect()->route('user.home');
        } else if ($user->role == 1) {
            return redirect()->route('admin.home');
        }
        return redirect()->route('user.home');
    }
}
