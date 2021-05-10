<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit46f36c3b0e01cab555068c3290b84edc
{
    public static $prefixLengthsPsr4 = array (
        'a' => 
        array (
            'app\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'app\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit46f36c3b0e01cab555068c3290b84edc::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit46f36c3b0e01cab555068c3290b84edc::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit46f36c3b0e01cab555068c3290b84edc::$classMap;

        }, null, ClassLoader::class);
    }
}
