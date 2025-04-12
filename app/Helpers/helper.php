<?php

use Illuminate\Support\Str;

if (! function_exists('limitText')) {
    function limitText(string $text, int $length = 100, string $end = '...'): string
    {
        return Str::limit(strip_tags($text), $length, $end);
    }
}