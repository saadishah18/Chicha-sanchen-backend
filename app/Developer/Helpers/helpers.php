<?php

use App\Service\Facades\Api;

include "image_upload.php";

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

if (!function_exists('imagePath')) {

    function imagePath($path)
    {
            return asset('storage/').'/'.$path;
    }
}
if (!function_exists('removeAnyDomainFromUrl')) {
    function removeAnyDomainFromUrl($url)
    {
        $path = $url;
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            $host = parse_url($url, PHP_URL_HOST);
            if (!empty($host)) {
                $path = parse_url($url, PHP_URL_PATH);
            } else {
                $path = $url;
            }
        }
        return $path;
    }
}

if (!function_exists('removeDomainFromUrl')) {
    function removeDomainFromUrl($url)
    {
        $path = $url;
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            $host = parse_url($url, PHP_URL_HOST);
            if ($host == 'viconsortium.com') {
                $path = parse_url($url, PHP_URL_PATH);
            } else {
                $path = $url;
            }
        }
        return $path;
    }
}

function image_validation($image)
{
    if($image != null || $image  != ''){
        $fileExtension = substr(strrchr($image->getClientOriginalName(), '.'), 1);
        if ($fileExtension != 'jpg' && $fileExtension != 'jpeg' && $fileExtension != 'png' && $fileExtension != 'gif') {
            return Api::error('Image extension should be jpeg,jpg,png,and gif');
        }
        $filesize = \File::size($image);
        if ($filesize >= 1024 * 1024 * 20) {
            return Api::error('Image size should less than 20 mb');
        }

        return true;
    }
}


function generateUniqueOrderId() {
//    // Generate a UUID and remove hyphens
//    $uuid = str_replace('-', '', \Illuminate\Support\Str::uuid());
//
//    // Optionally prefix the UUID with a character or string
//    return 'ORD-' . $uuid;

    // Customize format as needed
    $format = 'ORD-' . date('Ymd') . '-';

    // Attempt to create unique number with a loop
    do {
        $uniqueId = $format . str_pad(mt_rand(1000, 9999), 4, '0', STR_PAD_LEFT);
        $existingOrder = \App\Models\Order::where('order_unique_id', $uniqueId)->first();
    } while ($existingOrder);

    return $uniqueId;
}
