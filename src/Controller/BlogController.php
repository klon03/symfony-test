<?php

declare(strict_types=1);

namespace App\Controller;
use App\Entity\Article;
use App\Entity\Image;
use App\Repository\ArticleRepository;
use App\Repository\ImageRepository;
use App\Services\ArticleManager;
use App\Services\ArticlesProvider;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BlogController extends AbstractController
{
    public function __construct (
        private ArticleRepository $articleRepository,
        private ArticlesProvider $articleProvider,
        private ArticleManager $articleManager,
        private ImageRepository $imageRepository,
    )
    {
    }

    #[Route('/main', name: 'blog', methods: ['GET'])]
    public function mainPage(Request $request):Response
    {
        $search = $request->get('search');
        $articles = $this->articleRepository->searchArticles($search);
        $data = $this->articleProvider->transformArticleList($articles);

        return $this->render('blog/articles.html.twig', $data);
    }

    #[Route('/article/{id}', name: 'article', methods: ['GET'])]
    public function article(Int $id):Response
    {
        $article = $this->articleRepository->find($id);
        return $this->render('blog/article.html.twig', ['article' => $article, 'images' => $article->getImages()->getValues()]);
    }

    #[Route('/article/{id}/edit', name: 'editArticleForm', methods: ['GET'])]
    public function editArticleForm(Int $id): Response
    {
        $article = $this->articleRepository->find($id);
        $form = $this->articleManager->createArticleForm($article);

        return $this->render('blog/editArticle.html.twig', ['form' => $form->createView(), 'article' => $article, 'images' => $article->getImages()->getValues()]);
    }

    #[Route('/article/{id}/edit', name: 'editArticleProcess', methods: ['POST'])]
    public function editArticleProcess(Request $request, Int $id): Response
    {
        $article = $this->articleRepository->find($id);

        if ($this->articleManager->handleArticleForm($request, $article)) {
            return $this->redirectToRoute('article', ['id' => $article->getId()]);
        }

        return $this->redirectToRoute('editArticleForm', ['id' => $article->getId()]);
    }

    #[Route('/add/article', name: 'addArticleForm', methods: ['GET'])]
    public function addArticleForm(): Response
    {
        $form = $this->articleManager->createArticleForm(new Article());
        return $this->render('blog/addArticle.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/add/article', name: 'addArticleProcess', methods: ['POST'])]
    public function addArticleProcess(Request $request): Response
    {
        $article = new Article();

        if ($this->articleManager->handleArticleForm($request, $article)) {
            return $this->redirectToRoute('article', ['id' => $article->getId()]);
        }

        return new Response(null, Response::HTTP_BAD_REQUEST);
    }

    #[Route('article/{id}/delete', name: 'deleteArticle')]
    public function deleteArticle(Int $id, EntityManagerInterface $entityManager): Response
    {
        $article = $this->articleRepository->find($id);
        $entityManager->remove($article);
        $entityManager->flush();
        return $this->redirectToRoute('blog');
    }

    #[Route('/article/deleteImage/{id}', name: 'deleteImage', methods: ['GET'])]
    public function deleteImage(Int $id, Image $image, EntityManagerInterface $entityManager): Response
    {
        $image = $this->imageRepository->find($id);
        $articleId = $image->getArticle()->getId();
        $entityManager->remove($image);
        $entityManager->flush();
        return $this->redirectToRoute('editArticleForm', ['id' => $articleId]);
    }
}
