<?php

namespace App\EntityListener;

use App\Entity\Article;
use Symfony\Component\Uid\Uuid;
use App\Service\ImageUploaderService;

/**
 * @package App\EntityListener
 */
class ArticleListener
{
    private $uploadImageArticleDir;
    private $uploadImageArticleAbdosulteDir;

    public function __construct(string $uploadImageArticleDir, string $uploadImageArticleAbdosulteDir)
    {
        $this->uploadImageArticleDir = $uploadImageArticleDir;
        $this->uploadImageArticleAbdosulteDir = $uploadImageArticleAbdosulteDir;
    }

    public function prePersist(Article $article): void
    {
        $this->upload($article);
    }

    public function preUpdate(Article $article): void
    {
        $this->upload($article);
    }


    private function upload(Article $article): void
    {
        $filename = sprintf("%s.%s", Uuid::v4(), $article->getFile()->getClientOriginalExtension());

        $article->getFile()->move($this->uploadImageArticleAbdosulteDir, $filename);
        $article->setImage(sprintf("%s/%s", $this->uploadImageArticleDir, $filename));
    }
}