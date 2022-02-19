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
        //$this->generateComment($manager);
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
        $trick = new Trick();
        $trick->setUser($manager->find(User::class, 1));
        $trick->setName('Stalefish');
        $trick->setDescription('Stalefish');
        $trick->setCategory($manager->find(Category::class, 1));
        $trick->setSlug('stalefish');
        $this->persistEntity($manager, $trick);
    }

}
