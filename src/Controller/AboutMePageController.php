<?php

namespace App\Controller;

use App\Form\AboutMeInfoType;
use App\Form\ArticleType;
use App\Repository\AboutMeRepository;
use App\Repository\ArticleRepository;
use App\Services\AboutMeProvider;
use App\Services\ArticlesProvider;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AboutMePageController extends AbstractController
{
    public function __construct (
        private AboutMeRepository $aboutMeRepository,
        private AboutMeProvider $aboutMeProvider,
    )
    {
    }

    #[Route('/about-me', name: 'aboutMeMain', methods: ['GET'])]
    public function index(): Response
    {
        $info = $this->aboutMeRepository->findAll();
        $form = $this->createForm(AboutMeInfoType::class);

        $data = [];
        if (count($info) > 0) {
            $data = $this->aboutMeProvider->transformAboutData($info);
        }

        return $this->render('about_me_page/index.html.twig', ['info' => $data['info'], 'form' => $form]);
    }

    #[Route('/about-me', name: 'aboutMeAdd', methods: ['POST'])]
    public function addNew(Request $request): Response
    {
        $form = $this->createForm(AboutMeInfoType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newInfo = $form->getData();
            $this->aboutMeRepository->insert($newInfo);


            return $this->redirectToRoute('aboutMeMain');
        }
        return new Response(null, Response::HTTP_BAD_REQUEST);
    }

}
