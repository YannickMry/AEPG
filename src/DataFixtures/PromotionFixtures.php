<?php

namespace App\DataFixtures;

use DateTime;
use DateTimeImmutable;
use App\Entity\Promotion;
use DateInterval;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PromotionFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {

        for ($i = 0; $i < 6; $i++) {
            $date = new DateTime('now');
            $date->sub(new DateInterval(sprintf('P%dY', $i)));

            $promotion = (new Promotion())
                ->setYear(DateTimeImmutable::createFromMutable($date));
            $manager->persist($promotion);
        }

        $manager->flush();
    }
}
