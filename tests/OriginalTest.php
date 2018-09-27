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

class OriginalTest extends TestCase
{
    public function testOriginal()
    {
        $originalClass = new \ComposerOverload\Tests\Resources\OriginalClass();
        $this->assertEquals('OriginalClass', $originalClass->getOutput());
    }
}
