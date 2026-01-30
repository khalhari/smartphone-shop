<?php

use App\Models\Setting;

if (!function_exists('setting')) {
    /**
     * جلب قيمة إعداد معين من قاعدة البيانات
     *
     * @param string $key مفتاح الإعداد
     * @param mixed $default القيمة الافتراضية في حال عدم الوجود
     * @return mixed
     */
    function setting($key, $default = null)
    {
        // استدعاء الدالة get التي قمت بتعريفها مسبقاً في موديل Setting
        return Setting::get($key, $default);
    }
}
