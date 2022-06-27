<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public const ADMIN_USER_REFERENCE = 'admin-user';
    public const SIMPLE_USER_REFERENCE = 'simple-user';

    /**
     * Load data fixtures with the passed EntityManager
     */
    public function load(ObjectManager $manager)
    {
        /*  Creating admin user */
        $userAdmin = new User();
        $userAdmin->setUsername('Administrateur');
        $userAdmin->setEmail('admin@snowtricks.fr');
        $userAdmin->setIsVerified(true);
        $userAdmin->setRoles(["ROLE_ADMIN"]);
        $userAdmin->setPassword('$2y$13$pnXVA1WXxikRzYkc41FYPuyhVA4Dcv57uOjP9bAgQuRr8aXVHY17q');

        /*  Creating simple user */
        $simpleUser = new User();
        $simpleUser->setUsername('Judabricot');
        $simpleUser->setEmail('judas.bricot@snowtricks.fr');
        $simpleUser->setIsVerified(true);
        $simpleUser->setRoles([]);
        $simpleUser->setPassword('$2y$13$pnXVA1WXxikRzYkc41FYPuyhVA4Dcv57uOjP9bAgQuRr8aXVHY17q');

        $manager->persist($userAdmin);
        $manager->persist($simpleUser);
        $manager->flush();

        $this->addReference(self::ADMIN_USER_REFERENCE, $userAdmin);
        $this->addReference(self::SIMPLE_USER_REFERENCE, $simpleUser);
    }
}