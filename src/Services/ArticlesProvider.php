<?php

namespace App\Services;
class ArticlesProvider
{
    public function transformArticleList(array $articles): array {
        $transformedArticles = [];
        foreach ($articles as $article) {
            $date = $article->getCreated()->format('d.m.Y');
            $images = $article->getImages();

            if (!$images->isEmpty()) {
                $imagePath = $images->first()->getPath();
            } else {
                $imagePath = '/img/placeholder.png';
            }

            $transformedArticles['articles'][] = [
                'title' => $article->getTitle(),
                'content' => substr($article->getContent(), 0, 80) . '...',
                'link' => '/article/' .$article->getId(),
                'linkEdit' => '/article/' .$article->getId() . '/edit',
                'linkDelete' => '/article/' .$article->getId() . '/delete',
                'created' => $date,
                'imagePath' =>$imagePath,
            ];
        }

        return $transformedArticles;
    }
}
