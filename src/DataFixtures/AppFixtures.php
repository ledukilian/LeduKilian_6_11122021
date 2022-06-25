<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Trick;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    const USERS = [
        [
            'username' => 'Admin',
            'email' => 'Admin@Snowtricks.fr',
            'roles' => ["ROLE_ADMIN"],
            'password' => '$2y$13$pnXVA1WXxikRzYkc41FYPuyhVA4Dcv57uOjP9bAgQuRr8aXVHY17q'
        ],
        [
            'username' => 'Guimauve',
            'email' => 'guy.mauve@Snowtricks.fr',
            'roles' => [],
            'password' => '$2y$13$pnXVA1WXxikRzYkc41FYPuyhVA4Dcv57uOjP9bAgQuRr8aXVHY17q'
        ],
        [
            'username' => 'Judabrico',
            'email' => 'judas.bricot@Snowtricks.fr',
            'roles' => [],
            'password' => '$2y$13$pnXVA1WXxikRzYkc41FYPuyhVA4Dcv57uOjP9bAgQuRr8aXVHY17q'
        ]
    ];
    const CATEGORIES = [
        [
            'name' => 'Grab',
            'desc' => 'Un grab consiste à attraper la planche avec la main pendant le saut. Le verbe anglais to grab signifie « attraper »'
        ],
        [
            'name' => 'Rotate',
            'desc' => 'On désigne par le mot « rotate » uniquement des rotations horizontales'
        ],
        [
            'name' => 'Flip',
            'desc' => 'Un flip est une rotation verticale. On distingue les front flips, rotations en avant, et les back flips, rotations en arrière.'
        ]
    ];
    const TRICKS = [
        [
            'name' => 'Stalefish',
            'desc' => 'Stalefish',
            'slug' => 'stalefish',
            'cat' => 1
        ],
        [
            'name' => 'Tail grab',
            'desc' => 'Tail grab',
            'slug' => 'tail-grab',
            'cat' => 1
        ],
        [
            'name' => 'Nose grab',
            'desc' => 'Nose grab',
            'slug' => 'nose-grab',
            'cat' => 1
        ],
        [
            'name' => '90',
            'desc' => 'Ceci est un 90',
            'slug' => '90',
            'cat' => 2
        ],
        [
            'name' => '180',
            'desc' => 'Ceci est un 180',
            'slug' => '180',
            'cat' => 2
        ],
        [
            'name' => '360',
            'desc' => 'Ceci est un 360',
            'slug' => '360',
            'cat' => 2
        ],
        [
            'name' => '540',
            'desc' => 'Ceci est un 540',
            'slug' => '540',
            'cat' => 2
        ],
        [
            'name' => 'Simple flip',
            'desc' => 'Ceci est un Simple flip',
            'slug' => 'simple-flip',
            'cat' => 3
        ],
        [
            'name' => 'Double flip',
            'desc' => 'Ceci est un Double flip',
            'slug' => 'double-flip',
            'cat' => 3
        ],
        [
            'name' => 'Hakon flip',
            'desc' => 'Ceci est un Hakon flip',
            'slug' => 'hakon-flip',
            'cat' => 3
        ]
    ];


    private function persistEntity(ObjectManager $manager, $entity): void {
        $entity->setCreatedAt(new \DateTimeImmutable());
        $entity->setUpdatedAt(new \DateTimeImmutable());
        $manager->persist($entity);
    }

    public function load(ObjectManager $manager): void
    {
        $users = [''];
        $categories = [''];

        /* Generating Users */
        foreach ($this::USERS as $data) {
            $user = new User();
            $user->setIsVerified(true);
            $user->setUsername($data['username']);
            $user->setEmail($data['email']);
            $user->setRoles($data['roles']);
            $user->setPassword($data['password']);
            $this->persistEntity($manager, $user);
            $users[] = $user;
        }
        /* Generating Categories */
        foreach ($this::CATEGORIES as $data) {
            $category = new Category();
            $category->setName($data['name']);
            $category->setDescription($data['desc']);
            $this->persistEntity($manager, $category);
            $categories[] = $category;
        }
        /* Generating Tricks */
        die;
        foreach ($this::TRICKS as $data) {
            $trick = new Trick();
            $trick->setUser($users[1]);
            $trick->setName($data['name']);
            $trick->setDescription($data['desc']);
            $trick->setCategory($categories[$data['cat']]);
            $trick->setSlug($data['slug']);
            $this->persistEntity($manager, $category);
            var_dump($trick);
            die;
        }
        $manager->flush();



    }


}
