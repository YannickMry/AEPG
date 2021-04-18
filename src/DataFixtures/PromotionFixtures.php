<?php

namespace App\DataFixtures;

use DateTimeImmutable;
use App\Entity\Promotion;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PromotionFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $year = 2021;
        for ($i = 0; $i < 6; $i++) {

            $year -= 1;
            $promotion = (new Promotion())
                ->setYear($year);
            $manager->persist($promotion);
        }

        $manager->flush();
    }
}
