<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Services\ArticleProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainPageController extends AbstractController
{
    public function __construct (
        private ArticleRepository $articleRepository,
        private ArticleProvider $articleProvider
    )
    {
    }

    #[Route('/', name: 'mainPage')]
    public function index(): Response
    {
        $latestArticle = $this->articleRepository->getLastArticle();
        if ($latestArticle) {
            $latestArticle = $this->articleProvider->provideArticleData($latestArticle);
        }
        return $this->render('main_page/index.html.twig', ['article' => $latestArticle]);
    }
}
