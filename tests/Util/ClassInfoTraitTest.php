<?php

/*
 * This file is part of the API Platform project.
 *
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace ApiPlatform\Tests\Util;

use ApiPlatform\Tests\Fixtures\TestBundle\Entity\Dummy;
use ApiPlatform\Util\ClassInfoTrait;
use PHPUnit\Framework\TestCase;

class ClassInfoTraitTest extends TestCase
{
    private function getClassInfoTraitImplementation()
    {
        return new class() {
            use ClassInfoTrait {
                ClassInfoTrait::getRealClassName as public;
            }
        };
    }

    public function testDoctrineRealClassName()
    {
        $classInfo = $this->getClassInfoTraitImplementation();

        $this->assertEquals(Dummy::class, $classInfo->getRealClassName('Proxies\__CG__\ApiPlatform\Tests\Fixtures\TestBundle\Entity\Dummy'));
    }

    public function testProxyManagerRealClassName()
    {
        $classInfo = $this->getClassInfoTraitImplementation();

        $this->assertEquals(Dummy::class, $classInfo->getRealClassName('MongoDBODMProxies\__PM__\ApiPlatform\Tests\Fixtures\TestBundle\Entity\Dummy\Generated'));
    }

    public function testUnmarkedRealClassName()
    {
        $classInfo = $this->getClassInfoTraitImplementation();

        $this->assertEquals(Dummy::class, $classInfo->getRealClassName(Dummy::class));
    }
}
