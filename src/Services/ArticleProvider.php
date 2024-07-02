<?php

namespace App\Services;

use App\Entity\Article;

class ArticleProvider
{
    public function provideArticleData(Article $article): array {


        $date = $article->getCreated()->format('H:i:s d.m.Y');
        return [
            'id' => $article->getId(),
            'title' => $article->getTitle(),
            'content' => substr($article->getContent(), 0, 80) . '...',
            'link' => '/article/' .$article->getId(),
//            'linkEdit' => '/article/' .$article->getId() . '/edit',
//            'linkDelete' => '/article/' .$article->getId() . '/delete',
            'created' => $date,
        ];
    }
}
