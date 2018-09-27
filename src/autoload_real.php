<?php

/*
 * This file is part of ComposerOverload.
 *
 * (c) Abel Katona
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class ComposerOverLoaderInit
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('ComposerOverload\ClassOverLoader' === $class) {
            require __DIR__.'/ClassOverLoader.php';
        }
    }

    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerOverLoaderInit', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \ComposerOverload\ClassOverLoader();
        spl_autoload_unregister(array('ComposerOverLoaderInit', 'loadClassLoader'));

        $composerDirectory = null;
        $files = array(
            __DIR__.'/../vendor/composer/autoload_real.php',
            __DIR__.'/../../../composer/autoload_real.php',
        );
        foreach ($files as $file) {
            if (file_exists($file)) {
                $composerDirectory = substr($file, 0, strrpos($file, "/autoload_real.php"));
            }
        }

        ///

        $map = require $composerDirectory.'/autoload_namespaces.php';
        foreach ($map as $namespace => $path) {
            $loader->set($namespace, $path);
        }

        $map = require $composerDirectory.'/autoload_psr4.php';
        foreach ($map as $namespace => $path) {
            $loader->setPsr4($namespace, $path);
        }

        $classMap = require $composerDirectory.'/autoload_classmap.php';
        if ($classMap) {
            $loader->addClassMap($classMap);
        }

        $loader->register(true);

        $includeFiles = require $composerDirectory.'/autoload_files.php';

        foreach ($includeFiles as $fileIdentifier => $file) {
            composerRequire($fileIdentifier, $file);
        }

        return $loader;
    }
}

function composerRequire($fileIdentifier, $file)
{
    if (empty($GLOBALS['__composer_autoload_files'][$fileIdentifier])) {
        require $file;

        $GLOBALS['__composer_autoload_files'][$fileIdentifier] = true;
    }
}
