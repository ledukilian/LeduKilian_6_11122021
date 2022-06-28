<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public const ADMIN_USER_REFERENCE = 'admin-user';
    public const SIMPLE_USER_REFERENCE = 'simple-user';
    public const SIMPLE_USER2_REFERENCE = 'simple-user2';
    public const SIMPLE_USER3_REFERENCE = 'simple-user3';

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
        $userAdmin->setImage('admin.png');
        $userAdmin->setPassword('$2y$13$pnXVA1WXxikRzYkc41FYPuyhVA4Dcv57uOjP9bAgQuRr8aXVHY17q');

        /*  Creating simple user */
        $simpleUser = new User();
        $simpleUser->setUsername('JudasBricot');
        $simpleUser->setEmail('judas.bricot@snowtricks.fr');
        $simpleUser->setIsVerified(true);
        $simpleUser->setRoles([]);
        $simpleUser->setImage('user.png');
        $simpleUser->setPassword('$2y$13$pnXVA1WXxikRzYkc41FYPuyhVA4Dcv57uOjP9bAgQuRr8aXVHY17q');

        /*  Creating simple user */
        $simpleUser2 = new User();
        $simpleUser2->setUsername('AlonzoSki');
        $simpleUser2->setEmail('alonzo.ski@snowtricks.fr');
        $simpleUser2->setIsVerified(true);
        $simpleUser2->setRoles([]);
        $simpleUser2->setImage('user2.png');
        $simpleUser2->setPassword('$2y$13$pnXVA1WXxikRzYkc41FYPuyhVA4Dcv57uOjP9bAgQuRr8aXVHY17q');

        /*  Creating simple user */
        $simpleUser3 = new User();
        $simpleUser3->setUsername('MaxHymale');
        $simpleUser3->setEmail('max.hymale@snowtricks.fr');
        $simpleUser3->setIsVerified(true);
        $simpleUser3->setRoles([]);
        $simpleUser3->setImage('user3.png');
        $simpleUser3->setPassword('$2y$13$pnXVA1WXxikRzYkc41FYPuyhVA4Dcv57uOjP9bAgQuRr8aXVHY17q');

        $manager->persist($userAdmin);
        $manager->persist($simpleUser);
        $manager->persist($simpleUser2);
        $manager->persist($simpleUser3);
        $manager->flush();

        $this->addReference(self::ADMIN_USER_REFERENCE, $userAdmin);
        $this->addReference(self::SIMPLE_USER_REFERENCE, $simpleUser);
        $this->addReference(self::SIMPLE_USER2_REFERENCE, $simpleUser2);
        $this->addReference(self::SIMPLE_USER3_REFERENCE, $simpleUser3);
    }
}