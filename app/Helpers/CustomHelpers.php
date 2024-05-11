<?php
namespace App\Helpers;



class CustomHelpers
{
    public static function formatDate($date, $format = 'Y-m-d')
    {
        return \Carbon\Carbon::parse($date)->format($format);
    }

    public static function cacheData($key, $data, $expiration = 60)
    {
        \Illuminate\Support\Facades\Cache::put($key, $data, $expiration);
    }


}
