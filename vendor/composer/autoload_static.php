<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit83fb2a7c0fd89ecaed52b0401a5f24c2
{
    public static $classMap = array (
        'Grav\\Plugin\\MarkdownNoticesPlugin' => __DIR__ . '/../..' . '/markdown-notices.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit83fb2a7c0fd89ecaed52b0401a5f24c2::$classMap;

        }, null, ClassLoader::class);
    }
}
