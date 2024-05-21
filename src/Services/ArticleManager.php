<?php

namespace App\Services;

use App\Entity\Article;
use App\Entity\Image;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class ArticleManager
{
    public function __construct (
        private readonly EntityManagerInterface $entityManager,
        private string                          $imagesDirectory,
        private readonly string                 $imagesDirectoryPublic,
        private readonly FormFactoryInterface   $formFactory)
    {
    }

    public function createArticleForm(Article $article): FormInterface
    {
        return $this->formFactory->create(ArticleType::class, $article);
    }

    public function handleArticleForm(Request $request, Article $article): bool
    {
        $form = $this->createArticleForm($article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if(!$article->getCreated()) {
                $article->setCreated(new \DateTime());
            }

            $imageFiles = $form->get('images')->getData();

            foreach ($imageFiles as $imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = bin2hex(random_bytes(6)).'.'.$imageFile->guessExtension();
                $imageFile->move($this->imagesDirectory, $newFilename);

                $image = new Image();
                $image->setPath($this->imagesDirectoryPublic . $newFilename);
                $image->setArticle($article);
                $image->setTitle($originalFilename);

                $this->entityManager->persist($image);
            }

            $this->entityManager->persist($article);
            $this->entityManager->flush();

            return true;
        }

        return false;
    }
}
