<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = session()->get('locale');

        if(empty($locale)){
             // Nếu không có giá trị ngôn ngữ trong session, kiểm tra trong cookie
            $locale = $request->cookie('locale');
        }
        if (!in_array($locale, config('app.locales'))) {
            $locale = config('app.fallback_locale');
        }

        app()->setLocale($locale);
        // Thiết lập ngôn ngữ cho ứng dụng

        return $next($request);
    }
}
