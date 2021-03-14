<?php

namespace App\Tests\Unit;

use App\Entity\News;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class NewsTest extends TestCase
{

    public function testNewsEntityGetterAndSetter()
    {
        $title = 'Title';
        $content = 'test';
        $image = 'image.png';
        $author = 'Jean Dupont';
        $isHidden = false;
        $createdAt = new DateTimeImmutable('now');

        $news = new News();

        $news->setTitle($title)
            ->setContent($content)
            ->setImage($image)
            ->setAuthor($author)
            ->setIsHidden($isHidden)
            ->setCreatedAt($createdAt);

        $this->assertInstanceOf(News::class, $news);
        $this->assertNull($news->getId());
        $this->assertEquals($title, $news->getTitle());
        $this->assertEquals($content, $news->getContent());
        $this->assertEquals($image, $news->getImage());
        $this->assertEquals($author, $news->getAuthor());
        $this->assertEquals($isHidden, $news->getIsHidden());
        $this->assertEquals($createdAt, $news->getCreatedAt());
    }
}
