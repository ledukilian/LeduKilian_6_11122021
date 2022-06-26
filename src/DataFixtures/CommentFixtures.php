<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public const COMMENTS = [
        'Très bon trick !',
        'Excellent !',
        'Formidable !',
        'Parfait en altitude !'
    ];

    public function load(ObjectManager $manager)
    {
        $tricks = [
            $this->getReference(TrickFixtures::TRICK_1_REFERENCE),
            $this->getReference(TrickFixtures::TRICK_2_REFERENCE),
            $this->getReference(TrickFixtures::TRICK_3_REFERENCE),
            $this->getReference(TrickFixtures::TRICK_4_REFERENCE),
            $this->getReference(TrickFixtures::TRICK_5_REFERENCE),
            $this->getReference(TrickFixtures::TRICK_6_REFERENCE),
            $this->getReference(TrickFixtures::TRICK_7_REFERENCE),
            $this->getReference(TrickFixtures::TRICK_8_REFERENCE),
            $this->getReference(TrickFixtures::TRICK_9_REFERENCE),
            $this->getReference(TrickFixtures::TRICK_10_REFERENCE)
        ];
        foreach ($tricks as $trick) {

            foreach ($this::COMMENTS as $text) {
                $comment = new Comment();
                $comment->setUser($this->getReference(UserFixtures::SIMPLE_USER_REFERENCE));
                $comment->setContent($text);
                $comment->setTrick($trick);
                $comment->setStatus(mt_rand(0, 1));
                $manager->persist($comment);
                $manager->flush();
            }
        }
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            TrickFixtures::class,
        ];
    }
}