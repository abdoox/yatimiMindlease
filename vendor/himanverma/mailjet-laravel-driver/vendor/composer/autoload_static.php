<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitce9592af5469fa58486c984f733a589c
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Themsaid\\MailPreview\\' => 21,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Themsaid\\MailPreview\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'MailPreviewTest' => __DIR__ . '/../..' . '/tests/MailPreviewTest.php',
        'TestCase' => __DIR__ . '/../..' . '/tests/TestCase.php',
        'Themsaid\\MailPreview\\MailPreviewController' => __DIR__ . '/../..' . '/src/MailPreviewController.php',
        'Themsaid\\MailPreview\\MailPreviewMiddleware' => __DIR__ . '/../..' . '/src/MailPreviewMiddleware.php',
        'Themsaid\\MailPreview\\MailProvider' => __DIR__ . '/../..' . '/src/MailProvider.php',
        'Themsaid\\MailPreview\\PreviewTransport' => __DIR__ . '/../..' . '/src/PreviewTransport.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitce9592af5469fa58486c984f733a589c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitce9592af5469fa58486c984f733a589c::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitce9592af5469fa58486c984f733a589c::$classMap;

        }, null, ClassLoader::class);
    }
}
