<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit03df4067e8aaab68d13314b36c32f5c0
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\System\\' => 11,
            'App\\Model\\' => 10,
            'App\\Controller\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\System\\' => 
        array (
            0 => __DIR__ . '/../..' . '/system',
        ),
        'App\\Model\\' => 
        array (
            0 => __DIR__ . '/../..' . '/model',
        ),
        'App\\Controller\\' => 
        array (
            0 => __DIR__ . '/../..' . '/controller',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit03df4067e8aaab68d13314b36c32f5c0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit03df4067e8aaab68d13314b36c32f5c0::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}