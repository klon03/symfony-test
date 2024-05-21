<?php

namespace App\DataFixtures;

use App\Entity\AboutMeInfo;
use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $article1 = new Article();
        $article1->setTitle('Article 1');
        $article1->setContent('Article 1 content');
        $article1->setCreated(new \DateTime('now'));
        $manager->persist($article1);

        $article2 = new Article();
        $article2->setTitle('Article 2');
        $article2->setContent('Article 2 content');
        $article2->setCreated(new \DateTime('12.04.2020 15:30'));
        $manager->persist($article2);

        $article3 = new Article();
        $article3->setTitle('Article 3');
        $article3->setContent('Article 3 content');
        $article3->setCreated(new \DateTime('16:15:21 16.12.2023'));
        $manager->persist($article3);

        $about1 = new AboutMeInfo();
        $about1->setKey('name');
        $about1->setValue('Jan');
        $manager->persist($about1);

        $about2 = new AboutMeInfo();
        $about2->setKey('lastname');
        $about2->setValue('Doe');
        $manager->persist($about2);

        $manager->flush();
    }
}
