<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BlogLike;

class BlogLikeController extends Controller
{
    public function toggle(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Bạn cần đăng nhập để thích bài viết!'], 401);
        }
        $userId = Auth::id();
        $blogId = $request->input('blog_id');
        $like = BlogLike::where('user_id', $userId)->where('blog_id', $blogId)->first();
        if ($like) {
            $like->delete();
            return response()->json(['liked' => false]);
        } else {
            BlogLike::create([
                'user_id' => $userId,
                'blog_id' => $blogId,
            ]);
            return response()->json(['liked' => true]);
        }
    }

    /**
     * Kiểm tra trạng thái like của user hiện tại với blog
     */
    public function isLiked(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['liked' => false]);
        }
        $userId = Auth::id();
        $blogId = $request->input('blog_id');
        $liked = BlogLike::where('user_id', $userId)->where('blog_id', $blogId)->exists();
        return response()->json(['liked' => $liked]);
    }
}
