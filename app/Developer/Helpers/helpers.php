<?php

if (!function_exists('getSettings')) {
    function getSettings($key)
    {
        return \Illuminate\Support\Facades\Cache::remember($key, getCacheRememberTime(), function () use ($key) {
            return \App\Models\Setting::where('key', $key)->firstOrFail();
        });
    }
}

if (!function_exists('getCacheRememberTime')) {
    function getCacheRememberTime()
    {
        $rememberTime = config('cache.timeout'); //3600 *24 == 1 day
        // dd($rememberTime);
        if ($rememberTime == 0) {
            cache()->flush();
        }
        return $rememberTime;
    }
}


if (!function_exists('authUser')) {

    function authUser()
    {
        if (auth()->check()) {
            return auth()->user();
        }
        return false;
    }
}

if (!function_exists('formatNumber')) {

    function formatNumber($number)
    {
        return (float) number_format($number,'2');
    }
}

if (!function_exists('generate_code')) {
    function generate_code($length): string
    {
        $code = array_merge(range(0, 9), range(0, 9));
        shuffle($code);
        return implode(array_slice($code, 0, $length));
    }
}
