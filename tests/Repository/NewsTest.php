<?php

namespace App\Tests\Repository;

use App\Repository\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class NewsTest extends KernelTestCase
{
    public function testCount()
    {
        self::bootKernel();
        $news = self::$container->get(NewsRepository::class)->count([]);

        $this->assertEquals(30, $news);
    }
}
