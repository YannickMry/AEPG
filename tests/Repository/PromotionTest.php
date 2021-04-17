<?php

namespace App\Tests\Repository;

use App\Repository\PromotionRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PromotionTest extends KernelTestCase
{
    public function testCount()
    {
        self::bootKernel();
        $promotion = self::$container->get(PromotionRepository::class)->count([]);

        $this->assertEquals(6, $promotion);
    }
}
