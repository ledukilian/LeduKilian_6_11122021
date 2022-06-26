<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public const CATEGORY_GRAB_REFERENCE = 'category-grab';
    public const CATEGORY_ROTATE_REFERENCE = 'category-rotate';
    public const CATEGORY_FLIP_REFERENCE = 'category-flip';

    public function load(ObjectManager $manager)
    {
        $cat_grab = new Category();
        $cat_grab->setName('Grab');
        $cat_grab->setDescription('Un grab consiste à attraper la planche avec la main pendant le saut. Le verbe anglais to grab signifie « attraper »');

        $cat_rotate = new Category();
        $cat_rotate->setName('Rotate');
        $cat_rotate->setDescription('On désigne par le mot « rotate » uniquement des rotations horizontales');

        $cat_flip = new Category();
        $cat_flip->setName('Flip');
        $cat_flip->setDescription('Un flip est une rotation verticale. On distingue les front flips, rotations en avant, et les back flips, rotations en arrière.');


        $manager->persist($cat_grab);
        $manager->persist($cat_rotate);
        $manager->persist($cat_flip);
        $manager->flush();

        $this->addReference(self::CATEGORY_GRAB_REFERENCE, $cat_grab);
        $this->addReference(self::CATEGORY_ROTATE_REFERENCE, $cat_rotate);
        $this->addReference(self::CATEGORY_FLIP_REFERENCE, $cat_flip);
    }

}