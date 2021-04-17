<?php

namespace App\Tests\Unit;

use App\Entity\Article;
use Cocur\Slugify\Slugify;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class ArticleTest extends TestCase
{

    public function testArticleEntityGetterAndSetter()
    {
        $slugify = new Slugify();
        $title = 'Test Title';
        $slug = $slugify->slugify($title);
        $content = 'test';
        $image = 'image.png';
        $author = 'Jean Dupont';
        $isHidden = false;
        $createdAt = new DateTimeImmutable('now');

        $article = new Article();

        $article->setTitle($title)
            ->setSlug($slug)
            ->setContent($content)
            ->setImage($image)
            ->setAuthor($author)
            ->setIsHidden($isHidden)
            ->setCreatedAt($createdAt);

        $this->assertInstanceOf(Article::class, $article);
        $this->assertNull($article->getId());
        $this->assertEquals($title, $article->getTitle());
        $this->assertEquals($slug, $article->getSlug());
        $this->assertEquals($content, $article->getContent());
        $this->assertEquals($image, $article->getImage());
        $this->assertEquals($author, $article->getAuthor());
        $this->assertEquals($isHidden, $article->getIsHidden());
        $this->assertEquals($createdAt, $article->getCreatedAt());
    }
}
