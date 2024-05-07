<?php

declare(strict_types=1);

namespace App\Controller;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Services\ArticlesProvider;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    public function __construct (
        private ArticleRepository $articleRepository,
        private ArticlesProvider $articleProvider
    )
    {
    }

    #[Route('/main', name: 'blog')]
    public function mainPage():Response
    {
        $articles = $this->articleRepository->findBy([], ['created' => 'DESC']);
        $data = [];
        if ($articles) {
            $data = $this->articleProvider->transformArticleList($articles);
        }

        return $this->render('blog/articles.html.twig', $data);
    }
    #[Route('/article/{id}', name: 'article', methods: ['GET'])]
    public function article(Int $id):Response
    {
        $article = $this->articleRepository->find($id);
        return $this->render('blog/article.html.twig', ['article' => $article]);
    }

    #[Route('/article/{id}/edit', name: 'editArticleForm', methods: ['GET'])]
    public function editArticleForm(Int $id): Response
    {
        $article = $this->articleRepository->find($id);

        $form = $this->createForm(ArticleType::class, $article);

        return $this->render('blog/editArticle.html.twig', ['form' => $form, 'article' => $article]);
    }

    #[Route('/article/{id}/edit', name: 'editArticleProcess', methods: ['POST'])]
    public function editArticleProcess(Request $request, Int $id, EntityManagerInterface $entityManager): Response
    {
        $article = $this->articleRepository->find($id);

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();
            $entityManager->flush();

            return $this->redirectToRoute('article',['id' => $id]);
        }

        return $this->render('blog/editArticle.html.twig', ['form' => $form, 'article' => $article]);
    }

    #[Route('article/{id}/delete', name: 'deleteArticle')]
    public function deleteArticle(Int $id, EntityManagerInterface $entityManager): Response
    {
        $article = $this->articleRepository->find($id);
        $entityManager->remove($article);
        $entityManager->flush();
        return $this->redirectToRoute('blog');
    }

    #[Route('/add/article', name: 'addArticleForm', methods: ['GET'])]
    public function addArticleForm(): Response
    {
        $form = $this->createForm(ArticleType::class);
        return $this->render('blog/addArticle.html.twig', ['form' => $form]);
    }

    #[Route('/add/article', name: 'addArticleProcess', methods: ['POST'])]
    public function addArticleProcess(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArticleType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('article',['id' => $article->getId()]);
        }

        return new Response(null, Response::HTTP_BAD_REQUEST);
    }



}
