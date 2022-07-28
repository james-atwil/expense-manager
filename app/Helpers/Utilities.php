<?php

use Illuminate\Support\Facades\Route;

/**
 * @param  int   $length
 * @param  bool  $unique_chars
 *
 * @return string
 */
function random_str(int $length = 32, bool $unique_chars = false): string
{
    $token = "";
    try {
        $bytes    = random_bytes($length * 3);
        $base64   = base64_encode($bytes);
        $purified = preg_replace("/[+=\/.]/", "", $base64);
        $token    = substr($purified, 0, $length);

    } catch (\Exception $e) {
        echo $e->getMessage();
    }

    return $token;
}

function is_current_route($routeName, $stringTrue = 'active', $stringFalse = ''): string
{
    $current = Route::currentRouteName();
    return $routeName === $current ? $stringTrue : $stringFalse;
}


