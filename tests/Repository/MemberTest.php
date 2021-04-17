<?php

namespace App\Tests\Repository;

use App\Repository\MemberRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MemberTest extends KernelTestCase
{
    public function testCount()
    {
        self::bootKernel();
        $members = self::$container->get(MemberRepository::class)->count([]);
        $this->assertEquals(150, $members);
    }
}
