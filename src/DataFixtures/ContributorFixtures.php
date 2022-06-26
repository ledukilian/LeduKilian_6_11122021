<?php

namespace App\DataFixtures;

use App\Entity\Contributor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ContributorFixtures extends Fixture implements DependentFixtureInterface
{

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
            for ($i = 1; $i <= 2; $i++) {
                $contributor = new Contributor();
                $contributor->setUser($this->getReference(UserFixtures::SIMPLE_USER_REFERENCE));
                $contributor->setTrick($trick);
                $manager->persist($contributor);
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