<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3699d1e5addcaee78662800cf92c71ce
{
    public static $files = array (
        '3a37ebac017bc098e9a86b35401e7a68' => __DIR__ . '/..',
        '2c102faa651ef8ea5874edb585946bce' => __DIR__ . '/..',
    );

    public static $prefixLengthsPsr4 = array (
        't' => 
        array (
            'test\\' => 5,
        ),
        'M' => 
        array (
            'MongoDB\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'test\\' => 
        array (
            0 => __DIR__ . '/../..',
        ),
        'MongoDB\\' => 
        array (
            0 => __DIR__ . '/..',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3699d1e5addcaee78662800cf92c71ce::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3699d1e5addcaee78662800cf92c71ce::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}