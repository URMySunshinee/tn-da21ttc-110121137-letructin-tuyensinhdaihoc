<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\user\HomeUserController;
use App\Http\Controllers\user\ChatController;
use App\Http\Controllers\user\MajorController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\Admin\BlogCategoryAdminController;
use App\Http\Controllers\BlogLikeController;
use Laravel\Socialite\Facades\Socialite;

use App\Http\Controllers\admin\HomeAdminController;
use App\Http\Controllers\admin\BlogAdminController;
use App\Http\Controllers\admin\UserAdminController;
use App\Http\Controllers\admin\ChatAdminController;
use App\Http\Controllers\admin\MajorAdminController;
use App\Http\Controllers\admin\MajorCategoryController;
use App\Http\Controllers\admin\SubjectCombinationController;
use App\Http\Controllers\admin\QuestionAdminController;
use App\Http\Controllers\admin\ReportAdminController;

use App\Http\Middleware\checkRoleAdmin;
use App\Http\Middleware\checkRoleUser;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\RedirectIfNotAuthenticated;
use App\Http\Middleware\CorsMiddleware;
use App\Http\Controllers\user\VisitController;
use App\Http\Middleware\CheckUserActive;

Route::get('home', [HomeUserController::class, 'index'])->name('user.home');
Route::get('/', [HomeUserController::class, 'index'])->name('user.home1');
Route::get('/major-list', [HomeUserController::class, 'majorList'])->name('user.majorList');
Route::get('/major-detail/{id}', [HomeUserController::class, 'majorDetail'])->name('user.majorDetail');
Route::get('/blog-list', [HomeUserController::class, 'blogList'])->name('user.blogList');
Route::get('/blog-detail/{id}', [HomeUserController::class, 'blogDetail'])->name('user.blogDetail');
Route::get('/thong-tin-xet-tuyen', [HomeUserController::class, 'admissionInfo'])->name('user.admissionInfo');
Route::get('/thong-tin-xet-tuyen/{section}', [HomeUserController::class, 'admissionDetail'])->name('user.admission.detail');
Route::get('/gioi-thieu-truong', [HomeUserController::class, 'aboutUs'])->name('user.aboutUs');

// Regular routes continue below
Route::post('/question-request', [QuestionController::class, 'create'])->name('user.questionRequest');
Route::get('/change-infor', [AuthController::class, 'changeInfor'])->name('user.changeInfor');
Route::post('/change-infor', [AuthController::class, 'update']);
Route::get('/change-password', [AuthController::class, 'changePassword'])->name('user.changePassword');
Route::post('/change-password', [AuthController::class, 'changePassword_']);
Route::get('/major-category/{id}', [MajorAdminController::class, 'getMajorByIdCategory']);

// API routes for subject combinations
Route::get('/api/subject-combinations/active', [SubjectCombinationController::class, 'getActiveSubjectCombinations']);
Route::get('/api/major/{id}/subject-combinations', [SubjectCombinationController::class, 'getMajorSubjectCombinations']);
Route::get('/api/major/{majorId}/method/{methodId}/subject-combinations', [SubjectCombinationController::class, 'getMajorSubjectCombinationsByMethod']);

// API routes for admission methods
Route::get('/api/admission-methods/active', [MajorAdminController::class, 'getActiveAdmissionMethods']);
Route::get('/api/major/{id}/admission-methods', [MajorAdminController::class, 'getMajorAdmissionMethods']);
Route::get('/api/major/{id}/admission-scores', [MajorAdminController::class, 'getMajorAdmissionScores']);
Route::get('/blog-category/{id}', [BlogAdminController::class, 'getBlogByIdCategory']);

//only member access
Route::middleware([CheckUserActive::class, checkRoleUser::class])->group(function () {
Route::get('/check-like/{id}', [MajorController::class, 'checkLike']);
Route::get('/react-major/{id}', [MajorController::class, 'reactMajor']);
Route::get('/unreact-major/{id}', [MajorController::class, 'unReactMajor']);
Route::get('/ai-chat', [HomeUserController::class, 'aiChat'])->name('user.aiChat');
Route::get('/load-message', [ChatController::class, 'loadMessage']);
Route::middleware([CorsMiddleware::class])->post('/chat', [ChatController::class, 'chat']);
}); // <-- Đóng group này


    //cant access after login
Route::middleware([RedirectIfAuthenticated::class])->group(function () {
Route::get('auth', [AuthController::class, 'showLoginForm'])->name('user.auth');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('email-reset', [EmailController::class, 'sendMailResetPass'])->name('user.sendMailResetPass');
Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('auth.reset-password');
Route::post('/reset-password/{token}', [AuthController::class, 'resetPassword_']);
Route::post('register', [AuthController::class, 'register'])->name('register');
});

// Google OAuth routes
Route::get('auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

//only access after login
Route::post('/logout', [authController::class, 'logout'])->middleware([RedirectIfNotAuthenticated::class])->name('logout');

//only admin access
Route::prefix('admin')->middleware([CheckUserActive::class, checkRoleAdmin::class])->group(function () {
Route::get('/', [HomeAdminController::class, 'index'])->name('admin.home');
Route::get('/blog', [BlogAdminController::class, 'index'])->name('admin.blog');
Route::get('/user', [UserAdminController::class, 'index'])->name('admin.user');
Route::get('/chat', [ChatAdminController::class, 'index'])->name('admin.chat');
Route::get('/question', [QuestionAdminController::class, 'index'])->name('admin.question');
Route::get('/major', [MajorAdminController::class, 'index'])->name('admin.major');
Route::get('/major-category', [MajorCategoryController::class, 'index'])->name('admin.majorCategory');
Route::get('/subject-combination', [SubjectCombinationController::class, 'index'])->name('admin.subjectCombination');
Route::get('/report', [ReportAdminController::class, 'index'])->name('admin.report');

Route::get('/blog/{id}', [BlogAdminController::class, 'updateView'])->name('admin.blog.updateView');
Route::post('/blog', [BlogAdminController::class, 'createBlog']);
Route::put('/blog/{id}', [BlogAdminController::class, 'updateBlog']);
Route::delete('/blog/{id}', [BlogAdminController::class, 'softDeleteBlog']);
Route::patch('/blog/restore/{id}', [BlogAdminController::class, 'restoreBlog']);

Route::get('/major/{id}', [MajorAdminController::class, 'updateView'])->name('admin.major.updateView');
Route::post('/major', [MajorAdminController::class, 'createMajor']);
Route::put('/major/{id}', [MajorAdminController::class, 'updateMajor'])->name('admin.major.update');
Route::delete('/major/{id}', [MajorAdminController::class, 'softDeleteMajor']);
Route::patch('/major/restore/{id}', [MajorAdminController::class, 'restoreMajor']);

Route::get('/major-category/{id}', [MajorCategoryController::class, 'updateView'])->name('admin.majorCategory.updateView');
Route::post('/major-category', [MajorCategoryController::class, 'createMajorCategory']);
Route::put('/major-category/{id}', [MajorCategoryController::class, 'updateMajorCategory']);
Route::delete('/major-category/{id}', [MajorCategoryController::class, 'softDeleteMajorCategory']);
Route::patch('/major-category/restore/{id}', [MajorCategoryController::class, 'restoreMajorCategory']);

// Subject Combination routes
Route::post('/subject-combination', [SubjectCombinationController::class, 'create'])->name('admin.subjectCombination.create');
Route::get('/subject-combination/{id}', [SubjectCombinationController::class, 'updateView'])->name('admin.subjectCombination.updateView');
Route::put('/subject-combination/{id}', [SubjectCombinationController::class, 'update'])->name('admin.subjectCombination.update');
Route::patch('/subject-combination/{id}/toggle', [SubjectCombinationController::class, 'toggleStatus'])->name('admin.subjectCombination.toggleStatus');
Route::delete('/subject-combination/{id}', [SubjectCombinationController::class, 'delete'])->name('admin.subjectCombination.delete');

Route::delete('/users/{id}', [UserAdminController::class, 'softDeleteUser'])->name('admin.user.softDelete');
Route::patch('/users/restore/{id}', [UserAdminController::class, 'restoreUser'])->name('admin.user.restore');

Route::delete('/questions/{id}', [QuestionAdminController::class, 'softDeleteQuestion'])->name('admin.question.softDelete');
Route::patch('/questions/restore/{id}', [QuestionAdminController::class, 'restoreQuestion'])->name('admin.question.restore');
Route::post('/questions/{id}/complete', [QuestionAdminController::class, 'complete'])->name('admin.question.complete');

// Trả lời tư vấn qua email (admin)
Route::post('/questions/{id}/reply', [\App\Http\Controllers\admin\QuestionReplyController::class, 'reply'])->name('admin.question.reply');

Route::get('/chat/{id}', [ChatAdminController::class, 'detailView'])->name('admin.chat.detailView');
Route::get('/load-message-admin/{id}', [ChatController::class, 'loadMessageAdmin']);

// Thêm route cho quản lý danh mục bài viết
Route::get('/blog-category', [BlogCategoryAdminController::class, 'index'])->name('admin.blogCategory');
Route::get('/blog-category/create', [BlogCategoryAdminController::class, 'create'])->name('admin.blogCategory.create');
Route::post('/blog-category', [BlogCategoryAdminController::class, 'store'])->name('admin.blogCategory.store');
Route::get('/blog-category/{id}/edit', [BlogCategoryAdminController::class, 'edit'])->name('admin.blogCategory.edit');
Route::put('/blog-category/{id}', [BlogCategoryAdminController::class, 'update'])->name('admin.blogCategory.update');
Route::delete('/blog-category/{id}', [BlogCategoryAdminController::class, 'destroy'])->name('admin.blogCategory.destroy');
Route::get('/questions/done', [QuestionAdminController::class, 'done'])->name('admin.questions.done');
Route::get('/questions/{id}/detail', [QuestionAdminController::class, 'detail'])->name('admin.question.detail');
});

// Đặt 2 route này ở ngoài cùng, không nằm trong bất kỳ group middleware nào
Route::post('/blog/{blog}/like', [BlogLikeController::class, 'toggle'])->name('blog.like');
Route::post('/blog/{blog}/is-liked', [BlogLikeController::class, 'isLiked'])->name('blog.isLiked');

// Visitor tracking is now handled by the TrackVisits middleware

// Route for visitor testing at the end of the file
Route::get('/test-visit', function (Request $request) {
    $now = now();
    $expiryTimestamp = $request->session()->get('visit_recorded_expiry');
    
    // Convert to a comparable format if it exists
    $expiryFormatted = $expiryTimestamp ? date('Y-m-d H:i:s', $expiryTimestamp) : null;
    $sessionExpired = $expiryTimestamp ? ($now->timestamp > $expiryTimestamp) : false;
    
    $visitData = [
        'session_has_flag' => $request->session()->has('visit_recorded'),
        'session_expiry_timestamp' => $expiryTimestamp,
        'session_expiry_formatted' => $expiryFormatted,
        'current_timestamp' => $now->timestamp,
        'current_time_formatted' => $now->format('Y-m-d H:i:s'),
        'is_session_expired' => $sessionExpired,
        'visit_stats' => App\Http\Controllers\user\VisitController::getVisitStats(),
        'ip_address' => $request->ip(),
        'user_agent' => $request->header('User-Agent')
    ];
    
    // Call the record visit method to trigger it and see if it works
    App\Http\Controllers\user\VisitController::recordVisit($request);
    
    return response()->json($visitData);
});
