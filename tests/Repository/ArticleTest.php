<?php

namespace App\Tests\Repository;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ArticleTest extends KernelTestCase
{
    public function testCount()
    {
        self::bootKernel();
        $article = self::$container->get(ArticleRepository::class)->count([]);

        $this->assertEquals(90, $article);
    }
}
