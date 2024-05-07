<?php

namespace App\Services;

class AboutMeProvider
{
    public function transformData(array $articles): array {
        $transformedArticles = [];
        foreach ($articles as $article) {
            $date = $article->getCreated()->format('d.m.Y');
            $transformedArticles['articles'][] = [
                'title' => $article->getTitle(),
                'content' => substr($article->getContent(), 0, 80) . '...',
                'link' => '/article/' .$article->getId(),
                'linkEdit' => '/article/' .$article->getId() . '/edit',
                'linkDelete' => '/article/' .$article->getId() . '/delete',
                'created' => $date,
            ];
        }

        return $transformedArticles;
    }
}
