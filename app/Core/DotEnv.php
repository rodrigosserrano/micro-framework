<?php

namespace App\Core;

use Error;

class DotEnv
{

    /**
     * This method read a .env file, looping line a line
     * Checks if line is not a comment
     * Checks if value is not null
     * Treaitment string 'KEY=VALUE'
     * Set in putenv
     * @return void
     */
    public static function load(): void
    {
        $env = APP_PATH.".env";
        if (!file_exists($env)) throw new Error('Env file not exists.');

        $file = fopen($env, 'r');
        while ($line = fgets($file)) {
            if(preg_match("/^[^#]+$/", $line)) {
                if ($valueEnv = strstr($line, '=', false)) {
                    $keyEnv = strstr($line, '=', true);
                    if(strlen(trim($valueEnv))<= 1) throw new Error("Invalid value from $keyEnv");
                }
                $line = preg_replace('/\s+/', ' ', trim($line));
                if (!empty($line)) putenv($line);
            }
        }
        fclose($file);
    }
}