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

        // namepaces
        $files = array(
            __DIR__.'/../vendor/composer/autoload_namespaces.php',
            __DIR__.'/../../composer/autoload_namespaces.php',
        );
        foreach ($files as $file) {
            if (file_exists($file)) {
                $map = require $file;
                foreach ($map as $namespace => $path) {
                    $loader->set($namespace, $path);
                }
                break;
            }
        }

        // psr4
        $files = array(
            __DIR__.'/../vendor/composer/autoload_psr4.php',
            __DIR__.'/../../composer/autoload_psr4.php',
        );
        foreach ($files as $file) {
            if (file_exists($file)) {
                $map = require $file;
                foreach ($map as $namespace => $path) {
                    $loader->set($namespace, $path);
                }
                break;
            }
        }

        // classmap
        $files = array(
            __DIR__.'/../vendor/composer/autoload_classmap.php',
            __DIR__.'/../../composer/autoload_classmap.php',
        );
        foreach ($files as $file) {
            if (file_exists($file)) {
                $classMap = require $file;
                if ($classMap) {
                    $loader->addClassMap($classMap);
                }
                break;
            }
        }

        $loader->register(true);

        // includefiles
        $files = array(
            __DIR__.'/../vendor/composer/autoload_files.php',
            __DIR__.'/../../composer/autoload_files.php',
        );
        foreach ($files as $file) {
            if (file_exists($file)) {
                $includeFiles = require $file;
                foreach ($includeFiles as $fileIdentifier => $file) {
                    composerRequire($fileIdentifier, $file);
                }
                break;
            }
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
