<?php

namespace App\DataFixtures;

use App\Entity\Trick;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TrickFixtures extends Fixture implements DependentFixtureInterface
{
    public const TRICK_1_REFERENCE = 'trick-1';
    public const TRICK_2_REFERENCE = 'trick-2';
    public const TRICK_3_REFERENCE = 'trick-3';
    public const TRICK_4_REFERENCE = 'trick-4';
    public const TRICK_5_REFERENCE = 'trick-5';
    public const TRICK_6_REFERENCE = 'trick-6';
    public const TRICK_7_REFERENCE = 'trick-7';
    public const TRICK_8_REFERENCE = 'trick-8';
    public const TRICK_9_REFERENCE = 'trick-9';
    public const TRICK_10_REFERENCE = 'trick-10';

    public function load(ObjectManager $manager)
    {
        $trick_1 = new Trick();
        $trick_1->setName('Stalefish');
        $trick_1->setDescription('Stalefish');
        $trick_1->setSlug('stalefish');
        $trick_1->setUser($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
        $trick_1->setCategory($this->getReference(CategoryFixtures::CATEGORY_GRAB_REFERENCE));
        $trick_1->addMedia($this->getReference(MediaFixtures::MEDIA_1_REFERENCE));
        $trick_1->addMedia($this->getReference(MediaFixtures::MEDIA_11_REFERENCE));
        $trick_1->setCoverImg($this->getReference(MediaFixtures::MEDIA_1_REFERENCE));

        $trick_2 = new Trick();
        $trick_2->setName('Tail grab');
        $trick_2->setDescription('Tail grab');
        $trick_2->setSlug('tail-grab');
        $trick_2->setUser($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
        $trick_2->setCategory($this->getReference(CategoryFixtures::CATEGORY_GRAB_REFERENCE));
        $trick_2->addMedia($this->getReference(MediaFixtures::MEDIA_2_REFERENCE));
        $trick_2->addMedia($this->getReference(MediaFixtures::MEDIA_12_REFERENCE));
        $trick_2->setCoverImg($this->getReference(MediaFixtures::MEDIA_2_REFERENCE));

        $trick_3 = new Trick();
        $trick_3->setName('Nose grab');
        $trick_3->setDescription('Nose grab');
        $trick_3->setSlug('nose-grab');
        $trick_3->setUser($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
        $trick_3->setCategory($this->getReference(CategoryFixtures::CATEGORY_GRAB_REFERENCE));
        $trick_3->addMedia($this->getReference(MediaFixtures::MEDIA_3_REFERENCE));
        $trick_3->setCoverImg($this->getReference(MediaFixtures::MEDIA_3_REFERENCE));

        $trick_4 = new Trick();
        $trick_4->setName('90 Rotate');
        $trick_4->setDescription('90 Rotate');
        $trick_4->setSlug('90-rotate');
        $trick_4->setUser($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
        $trick_4->setCategory($this->getReference(CategoryFixtures::CATEGORY_ROTATE_REFERENCE));
        $trick_4->addMedia($this->getReference(MediaFixtures::MEDIA_4_REFERENCE));
        $trick_4->setCoverImg($this->getReference(MediaFixtures::MEDIA_4_REFERENCE));

        $trick_5 = new Trick();
        $trick_5->setName('180 Rotate');
        $trick_5->setDescription('180 Rotate');
        $trick_5->setSlug('180-rotate');
        $trick_5->setUser($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
        $trick_5->setCategory($this->getReference(CategoryFixtures::CATEGORY_ROTATE_REFERENCE));
        $trick_5->addMedia($this->getReference(MediaFixtures::MEDIA_5_REFERENCE));
        $trick_5->setCoverImg($this->getReference(MediaFixtures::MEDIA_5_REFERENCE));

        $trick_6 = new Trick();
        $trick_6->setName('360 Rotate');
        $trick_6->setDescription('360 Rotate');
        $trick_6->setSlug('360-rotate');
        $trick_6->setUser($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
        $trick_6->setCategory($this->getReference(CategoryFixtures::CATEGORY_ROTATE_REFERENCE));
        $trick_6->addMedia($this->getReference(MediaFixtures::MEDIA_6_REFERENCE));
        $trick_6->setCoverImg($this->getReference(MediaFixtures::MEDIA_6_REFERENCE));

        $trick_7 = new Trick();
        $trick_7->setName('540 Rotate');
        $trick_7->setDescription('540 Rotate');
        $trick_7->setSlug('540-rotate');
        $trick_7->setUser($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
        $trick_7->setCategory($this->getReference(CategoryFixtures::CATEGORY_ROTATE_REFERENCE));
        $trick_7->addMedia($this->getReference(MediaFixtures::MEDIA_7_REFERENCE));
        $trick_7->setCoverImg($this->getReference(MediaFixtures::MEDIA_7_REFERENCE));

        $trick_8 = new Trick();
        $trick_8->setName('Simple flip');
        $trick_8->setDescription('Simple flip');
        $trick_8->setSlug('simple-flip');
        $trick_8->setUser($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
        $trick_8->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_REFERENCE));
        $trick_8->addMedia($this->getReference(MediaFixtures::MEDIA_8_REFERENCE));
        $trick_8->setCoverImg($this->getReference(MediaFixtures::MEDIA_8_REFERENCE));

        $trick_9 = new Trick();
        $trick_9->setName('Double flip');
        $trick_9->setDescription('Double flip');
        $trick_9->setSlug('double-flip');
        $trick_9->setUser($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
        $trick_9->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_REFERENCE));
        $trick_9->addMedia($this->getReference(MediaFixtures::MEDIA_9_REFERENCE));
        $trick_9->setCoverImg($this->getReference(MediaFixtures::MEDIA_9_REFERENCE));


        $trick_10 = new Trick();
        $trick_10->setName('Hakon flip');
        $trick_10->setDescription('Hakon flip');
        $trick_10->setSlug('hakon-flip');
        $trick_10->setUser($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
        $trick_10->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_REFERENCE));
        $trick_10->addMedia($this->getReference(MediaFixtures::MEDIA_10_REFERENCE));
        $trick_10->setCoverImg($this->getReference(MediaFixtures::MEDIA_10_REFERENCE));

        $manager->persist($trick_1);
        $manager->persist($trick_2);
        $manager->persist($trick_3);
        $manager->persist($trick_4);
        $manager->persist($trick_5);
        $manager->persist($trick_6);
        $manager->persist($trick_7);
        $manager->persist($trick_8);
        $manager->persist($trick_9);
        $manager->persist($trick_10);
        $manager->flush();

        $this->addReference(self::TRICK_1_REFERENCE, $trick_1);
        $this->addReference(self::TRICK_2_REFERENCE, $trick_2);
        $this->addReference(self::TRICK_3_REFERENCE, $trick_3);
        $this->addReference(self::TRICK_4_REFERENCE, $trick_4);
        $this->addReference(self::TRICK_5_REFERENCE, $trick_5);
        $this->addReference(self::TRICK_6_REFERENCE, $trick_6);
        $this->addReference(self::TRICK_7_REFERENCE, $trick_7);
        $this->addReference(self::TRICK_8_REFERENCE, $trick_8);
        $this->addReference(self::TRICK_9_REFERENCE, $trick_9);
        $this->addReference(self::TRICK_10_REFERENCE, $trick_10);
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            CategoryFixtures::class,
            MediaFixtures::class,
        ];
    }
}