<?php


use Fomvasss\Variable\Models\Variable;
use Illuminate\Support\Facades\Cache;

if (! function_exists('variable')) {
    function variable(string $key, $default = null)
    {
        return Cache::rememberForever("variable_{$key}", function () use ($key, $default) {
            return Variable::where('key', $key)->value('value') ?? $default;
        });
    }
}