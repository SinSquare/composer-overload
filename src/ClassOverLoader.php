<?php

/*
 * This file is part of ComposerOverload.
 *
 * (c) Abel Katona
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ComposerOverload;

if (!\function_exists("Composer\Autoload\includeFile")) {
    $files = array(
        __DIR__.'/../vendor/composer/ClassLoader.php',
        __DIR__.'/../../composer/ClassLoader.php',
    );

    foreach ($files as $file) {
        if (file_exists($file)) {
            $loader = require_once $file;
            break;
        }
    }
}

class ClassOverLoader extends \Composer\Autoload\ClassLoader
{
    protected $overloadedClasses = [];

    public function findFile($class)
    {
        if (!empty($this->overloadedClasses[$class])) {
            return $this->overloadedClasses[$class];
        }

        return parent::findFile($class);
    }

    public function getOverloadedClasses()
    {
        return $this->overloadedClasses;
    }

    public function setOverloadedClasses(array $overloadedClasses)
    {
        $this->overloadedClasses = $overloadedClasses;

        return $this;
    }

    public function addOverloadedClass(string $originalClass, string $newClassLocation)
    {
        $this->overloadedClasses[$originalClass] = $newClassLocation;

        return $this;
    }
}
