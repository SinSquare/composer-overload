<?php

/*
 * This file is part of ComposerOverload.
 *
 * (c) Abel Katona
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

call_user_func(function () {
    require_once __DIR__.'/../../src/autoload_real.php';
    $loader = ComposerOverLoaderInit::getLoader();

    $GLOBALS['AUTOLOADER'] = $loader;
});
