<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Trick;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->generateUser($manager);
        $this->generateCategory($manager);
        $this->generateTrick($manager);
        $this->generateComment($manager);
        //$this->generateContributor($manager);
        $manager->flush();
    }

    private function persistEntity(ObjectManager $manager, $entity): void {
        $entity->setCreatedAt(new DateTime());
        $entity->setUpdatedAt(new DateTime());
        $manager->persist($entity);

    }

    private function generateUser(ObjectManager $manager)
    {
        // Creating first user : admin
        $user = new User();
        $user->setUsername('Admin');
        $user->setEmail('Admin@Snowtricks.fr');
        $user->setRoles(["ROLE_ADMIN"]);
        $user->setPassword('$2y$13$pnXVA1WXxikRzYkc41FYPuyhVA4Dcv57uOjP9bAgQuRr8aXVHY17q');
        $user->setIsVerified(true);
        $this->persistEntity($manager, $user);

        // Creating second user : member
        $user = new User();
        $user->setUsername('Guimauve');
        $user->setEmail('guy.mauve@Snowtricks.fr');
        $user->setRoles([]);
        $user->setPassword('$2y$13$pnXVA1WXxikRzYkc41FYPuyhVA4Dcv57uOjP9bAgQuRr8aXVHY17q');
        $user->setIsVerified(true);
        $this->persistEntity($manager, $user);
    }

    private function generateCategory(ObjectManager $manager)
    {
        // Creating first category
        $category = new Category();
        $category->setName('Grab');
        $category->setDescription('Un grab consiste à attraper la planche avec la main pendant le saut. Le verbe anglais to grab signifie « attraper »');
        $this->persistEntity($manager, $category);

        // Creating category
        $category = new Category();
        $category->setName('Rotate');
        $category->setDescription('On désigne par le mot « rotate » uniquement des rotations horizontales');
        $this->persistEntity($manager, $category);

        // Creating category
        $category = new Category();
        $category->setName('Flip');
        $category->setDescription('Un flip est une rotation verticale. On distingue les front flips, rotations en avant, et les back flips, rotations en arrière.');
        $this->persistEntity($manager, $category);
    }

    private function generateTrick(ObjectManager $manager)
    {
        // 1
        $trick = new Trick();
        $trick->setUser($manager->find(User::class, 1));
        $trick->setName('Stalefish');
        $trick->setDescription('Stalefish');
        $trick->setCategory($manager->find(Category::class, 1));
        $trick->setSlug('stalefish');
        $this->persistEntity($manager, $trick);
        // 2
        $trick->setName('Tail grab');
        $trick->setDescription('Tail grab');
        $trick->setSlug('tail-grab');
        $this->persistEntity($manager, $trick);
        // 3
        $trick->setName('Nose grab');
        $trick->setDescription('Nose grab');
        $trick->setSlug('nose-grab');
        $this->persistEntity($manager, $trick);
        // 4
        $trick->setName('90');
        $trick->setDescription('Ceci est un 90');
        $trick->setSlug('90');
        $trick->setCategory($manager->find(Category::class, 2));
        $this->persistEntity($manager, $trick);
        // 5
        $trick->setName('180');
        $trick->setDescription('Ceci est un 180');
        $trick->setSlug('180');
        $this->persistEntity($manager, $trick);
        // 6
        $trick->setName('360');
        $trick->setDescription('Ceci est un 360');
        $trick->setSlug('360');
        $this->persistEntity($manager, $trick);
        // 7
        $trick->setName('540');
        $trick->setDescription('Ceci est un 540');
        $trick->setSlug('540');
        $this->persistEntity($manager, $trick);
        // 8
        $trick->setName('Simple flip');
        $trick->setDescription('Simple flip');
        $trick->setSlug('simple-flip');
        $trick->setCategory($manager->find(Category::class, 3));
        $this->persistEntity($manager, $trick);
        // 9
        $trick->setName('Double flip');
        $trick->setDescription('Double flip');
        $trick->setSlug('double-flip');
        $this->persistEntity($manager, $trick);
        // 10
        $trick->setName('Hakon flip');
        $trick->setDescription('Hakon flip');
        $trick->setSlug('hakon-flip');
        $this->persistEntity($manager, $trick);
    }

    private function generateComment(ObjectManager $manager)
    {
        // 1
        $comment = new Comment();
        $comment->setContent();
        $this->persistEntity($manager, $trick);
    }

}
