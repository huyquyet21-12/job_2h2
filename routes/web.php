<?php

use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::get('/login',[AuthController::class,'login'])->name('login');
Route::get('/register',[AuthController::class,'register'])->name('register');
Route::post('/register',[AuthController::class,'registering'])->name('registering');

Route::get('/', function () {
    return view('layout.master');
});
Route::get('/auth/redirect/{provider}', function ($provider) {
    return Socialite::driver($provider)->redirect();
 
    // $user->token
    //chuyen huong den trang cung cap dich vu OAuth.  Người dùng sẽ được yêu cầu đăng nhập và cấp quyền truy cập cho ứng dụng
})->name('auth.redirect');

//callback de dieu huong
Route::get('/auth/callback/{provider}',[AuthController::class,'callback'])->name('auth.callback');
//Xu li callBack sau khi nguoi dung da dang nhap bang dich vu OAuth, truyen gia tri den ham provider

Route::get('logout',[AuthController::class,'logout'])->name('logout');
Route::get('/',function() {
    return view('layout.master');
})->name('welcome');

Route::get('language/{locale}', function($locale) {
    // Kiểm tra xem giá trị $locale có nằm trong danh sách các ngôn ngữ hợp lệ hay không
    if (!in_array($locale, config('app.locales'))) {
        // Nếu không hợp lệ, gán $locale thành ngôn ngữ mặc định được định nghĩa trong fallback_locale
        $locale = config('app.fallback_locale');
    }

    session()->put('locale', $locale);
    //lưu giá trị vào trong session

    // setcookie('locale')
    return redirect()->back()->withCookie(cookie('locale', $locale, 60 * 24 * 30));
    //trả về phản hồi và thiết lập cookie
})->name('language');
