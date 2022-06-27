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
        'Vous êtes top !! Continuez c\'est super :D',
        'Tu proposerais quoi comme planche pour ce genre de sortie pour quelqu\'un d\'1m83 92kgs...  Merci s\'avance',
        'Parfait en altitude !',
        'Ha ha sympas!!!',
        'A cause de toi je commence mes premiers cours de snow ce week end ...'
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
        $users = [
            $this->getReference(UserFixtures::ADMIN_USER_REFERENCE),
            $this->getReference(UserFixtures::SIMPLE_USER_REFERENCE),
            $this->getReference(UserFixtures::SIMPLE_USER2_REFERENCE),
            $this->getReference(UserFixtures::SIMPLE_USER3_REFERENCE)
        ];

        foreach ($tricks as $trick) {
            foreach ($this::COMMENTS as $text) {
                $comment = new Comment();
                $comment->setUser($users[array_rand($users)]);
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