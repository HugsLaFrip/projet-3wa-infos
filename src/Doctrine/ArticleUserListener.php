<?php

namespace App\Doctrine;

use App\Entity\Article;
use Symfony\Component\Security\Core\Security;

class ArticleUserListener
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function prePersist(Article $article): void
    {
        // Attach article's author to the article
        if (!$article->getUser()) {
            $article->setUser($this->security->getUser());
        }
    }
}
