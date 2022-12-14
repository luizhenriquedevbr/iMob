<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6625135483a78ca0e675594d44020978
{
    public static $files = array (
        'a4a119a56e50fbb293281d9a48007e0e' => __DIR__ . '/..' . '/symfony/polyfill-php80/bootstrap.php',
        '776224bdbf31c70ac5c141d6cb1f5769' => __DIR__ . '/../..' . '/bootstrap/bootstrap.php',
        'da231f5bc9ca77e9b7f84f284b9cc169' => __DIR__ . '/../..' . '/classes/host.php',
        '0f41486967c63ec1ae4448daab460d75' => __DIR__ . '/../..' . '/funcoes.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Polyfill\\Php80\\' => 23,
            'Symfony\\Component\\Process\\' => 26,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
        ),
        'K' => 
        array (
            'Knp\\Snappy\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Polyfill\\Php80\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-php80',
        ),
        'Symfony\\Component\\Process\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/process',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'Knp\\Snappy\\' => 
        array (
            0 => __DIR__ . '/..' . '/knplabs/knp-snappy/src/Knp/Snappy',
        ),
    );

    public static $classMap = array (
        'Autorizado' => __DIR__ . '/../..' . '/classes/Autorizado.php',
        'Cliente' => __DIR__ . '/../..' . '/classes/Cliente.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Contrato' => __DIR__ . '/../..' . '/classes/Contrato.php',
        'Gestao' => __DIR__ . '/../..' . '/classes/Gestao.php',
        'Host' => __DIR__ . '/../..' . '/classes/host.php',
        'Imovel' => __DIR__ . '/../..' . '/classes/Imovel.php',
        'Paginator' => __DIR__ . '/../..' . '/classes/Paginator.php',
        'Security' => __DIR__ . '/../..' . '/classes/Security.php',
        'Service' => __DIR__ . '/../..' . '/classes/Service.php',
        'Stringable' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/Stringable.php',
        'UnhandledMatchError' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/UnhandledMatchError.php',
        'ValueError' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/ValueError.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit6625135483a78ca0e675594d44020978::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit6625135483a78ca0e675594d44020978::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit6625135483a78ca0e675594d44020978::$classMap;

        }, null, ClassLoader::class);
    }
}
