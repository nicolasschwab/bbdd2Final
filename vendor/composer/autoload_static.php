<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit510868812b029f5d09c34a98a928b121
{
    public static $prefixesPsr0 = array (
        'T' => 
        array (
            'Twig_' => 
            array (
                0 => __DIR__ . '/..' . '/twig/twig/lib',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInit510868812b029f5d09c34a98a928b121::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}