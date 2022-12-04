<?php

class UtilsHelpers
{
    public static function dd(mixed $var, ?bool $die = true) : void
    {
        echo "<pre>".print_r($var,1)."</pre><br>";
        if ($die) die();
    }
}