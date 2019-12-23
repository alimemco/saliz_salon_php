<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2591c3a032d0dba3908b3427a66255f6
{
    public static $prefixLengthsPsr4 = array (
        'K' => 
        array (
            'Kavenegar\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Kavenegar\\' => 
        array (
            0 => __DIR__ . '/..' . '/kavenegar/php/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2591c3a032d0dba3908b3427a66255f6::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2591c3a032d0dba3908b3427a66255f6::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}