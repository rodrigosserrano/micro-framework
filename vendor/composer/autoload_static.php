<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9c5803a4a8496eb710f894c2f07fbae6
{
    public static $files = array (
        '5ff7b0941d8a154fe92b91227da15332' => __DIR__ . '/../..' . '/app/Helpers/UtilsHelpers.php',
    );

    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9c5803a4a8496eb710f894c2f07fbae6::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9c5803a4a8496eb710f894c2f07fbae6::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit9c5803a4a8496eb710f894c2f07fbae6::$classMap;

        }, null, ClassLoader::class);
    }
}
