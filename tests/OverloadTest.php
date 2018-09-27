<?php

/*
 * This file is part of ComposerOverload.
 *
 * (c) Abel Katona
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ComposerOverload\Tests;

use PHPUnit\Framework\TestCase;

class OverloadTest extends TestCase
{
    public function testOverload()
    {
        $loader = $GLOBALS['AUTOLOADER'];
        $loader->addOverloadedClass('ComposerOverload\\Tests\\Resources\\OriginalClass', __DIR__.'/Resources/OverloadedClass.php');

        $originalClass = new \ComposerOverload\Tests\Resources\OriginalClass();
        $this->assertEquals('OverloadedClass', $originalClass->getOutput());
    }

    public function testSetting()
    {
        $data = array(
            'abc' => 'cde',
            'efg' => 'hij',
        );

        $loader = $GLOBALS['AUTOLOADER'];
        $loader->setOverloadedClasses($data);

        $this->assertEquals($data, $loader->getOverloadedClasses());

        $data = array(
            'abc' => 'cde',
        );

        $loader->setOverloadedClasses($data);

        $this->assertEquals($data, $loader->getOverloadedClasses());
    }

    public function testAdding()
    {
        $loader = $GLOBALS['AUTOLOADER'];
        $loader->setOverloadedClasses(array());

        $loader->addOverloadedClass('orig', 'new');

        $this->assertEquals(array('orig' => 'new'), $loader->getOverloadedClasses());

        $loader->addOverloadedClass('orig2', 'new2');

        $this->assertEquals(array('orig' => 'new', 'orig2' => 'new2'), $loader->getOverloadedClasses());
    }
}
