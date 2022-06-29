<?php

namespace App\DataFixtures;

use App\Entity\Media;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MediaFixtures extends Fixture
{
    public const MEDIA_1_REFERENCE = 'media-1';
    public const MEDIA_2_REFERENCE = 'media-2';
    public const MEDIA_3_REFERENCE = 'media-3';
    public const MEDIA_4_REFERENCE = 'media-4';
    public const MEDIA_5_REFERENCE = 'media-5';
    public const MEDIA_6_REFERENCE = 'media-6';
    public const MEDIA_7_REFERENCE = 'media-7';
    public const MEDIA_8_REFERENCE = 'media-8';
    public const MEDIA_9_REFERENCE = 'media-9';
    public const MEDIA_10_REFERENCE = 'media-10';
    public const MEDIA_11_REFERENCE = 'media-11';
    public const MEDIA_12_REFERENCE = 'media-12';

    public function load(ObjectManager $manager)
    {
        $media_1 = new Media();
        $media_1->setType('image');
        $media_1->setLink('1.png');
        $media_1->setAlt('Image snowboard avec trainée de neige');

        $media_2 = new Media();
        $media_2->setType('image');
        $media_2->setLink('2.jpg');
        $media_2->setAlt('Image snowboard au soleil');

        $media_3 = new Media();
        $media_3->setType('image');
        $media_3->setLink('3.jpg');
        $media_3->setAlt('Image snowboard retourné');

        $media_4 = new Media();
        $media_4->setType('image');
        $media_4->setLink('4.jpg');
        $media_4->setAlt('Image snowboard de près');

        $media_5 = new Media();
        $media_5->setType('image');
        $media_5->setLink('5.jpg');
        $media_5->setAlt('Image snowboard avec trainée de neige');

        $media_6 = new Media();
        $media_6->setType('image');
        $media_6->setLink('6.jpg');
        $media_6->setAlt('Image snowboard avec montagnes en fond');

        $media_7 = new Media();
        $media_7->setType('image');
        $media_7->setLink('7.jpg');
        $media_7->setAlt('Image snowboard dans les arbres');

        $media_8 = new Media();
        $media_8->setType('image');
        $media_8->setLink('8.png');
        $media_8->setAlt('Image snowboard très rapide');


        $media_9 = new Media();
        $media_9->setType('image');
        $media_9->setLink('1.png');
        $media_9->setAlt('Image snowboard avec trainée de neige');

        $media_10 = new Media();
        $media_10->setType('image');
        $media_10->setLink('2.jpg');
        $media_10->setAlt('Image snowboard avec trainée de neige');


        $media_11 = new Media();
        $media_11->setType('video');
        $media_11->setLink('<iframe width="560" height="315" src="https://www.youtube.com/embed/EMVPpPE_Bx4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
        $media_11->setAlt('Intégration vidéo externe');

        $media_12 = new Media();
        $media_12->setType('video');
        $media_12->setLink('<iframe width="560" height="315" src="https://www.youtube.com/embed/_OMar04NRZw" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
        $media_12->setAlt('Intégration vidéo externe');

        $manager->persist($media_1);
        $manager->persist($media_2);
        $manager->persist($media_3);
        $manager->persist($media_4);
        $manager->persist($media_5);
        $manager->persist($media_6);
        $manager->persist($media_7);
        $manager->persist($media_8);
        $manager->persist($media_9);
        $manager->persist($media_10);
        $manager->persist($media_11);
        $manager->persist($media_12);
        $manager->flush();

        $this->addReference(self::MEDIA_1_REFERENCE, $media_1);
        $this->addReference(self::MEDIA_2_REFERENCE, $media_2);
        $this->addReference(self::MEDIA_3_REFERENCE, $media_3);
        $this->addReference(self::MEDIA_4_REFERENCE, $media_4);
        $this->addReference(self::MEDIA_5_REFERENCE, $media_5);
        $this->addReference(self::MEDIA_6_REFERENCE, $media_6);
        $this->addReference(self::MEDIA_7_REFERENCE, $media_7);
        $this->addReference(self::MEDIA_8_REFERENCE, $media_8);
        $this->addReference(self::MEDIA_9_REFERENCE, $media_9);
        $this->addReference(self::MEDIA_10_REFERENCE, $media_10);
        $this->addReference(self::MEDIA_11_REFERENCE, $media_11);
        $this->addReference(self::MEDIA_12_REFERENCE, $media_12);
    }
}