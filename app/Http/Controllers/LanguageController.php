<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * تبديل اللغة
     */
    public function switch(string $locale)
    {
        // التحقق من أن اللغة مدعومة
        if (!in_array($locale, config('app.available_locales', ['de', 'ar']))) {
            abort(400, 'Language not supported');
        }

        // حفظ اللغة في الـ Session
        Session::put('locale', $locale);

        // العودة للصفحة السابقة
        return redirect()->back()->with('success', 'Language changed successfully');
    }
}
