<?php

namespace TimFeid\Slack;

class Str
{
    public static function camel($value)
    {
        $value = lcfirst(ucwords(str_replace(['-', '_'], ' ', $value)));

        return str_replace(' ', '', $value);
    }

    public static function snake($value, $delimeter = '_')
    {
        $value = preg_replace('/\s+/u', '', $value);

        return mb_strtolower(preg_replace('/(.)(?=[A-Z])/u', '$1'.$delimeter, $value), 'UTF-8');
    }
}
