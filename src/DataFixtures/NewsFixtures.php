<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\News;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class NewsFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $bool = [true, false];
        $imageCategories = ['tech', 'arch', 'nature'];
        $imageFilters = ['', '/grayscale', '/sepia'];

        for ($i = 0; $i < 30; $i++) {
            $date = $faker->dateTimeBetween('-4 months', 'now', 'Europe/Paris');
            $image = sprintf(
                'https://placeimg.com/640/480/%s%s',
                $imageCategories[rand(0, 2)],
                $imageFilters[rand(0, 2)]
            );

            $news = (new News())
                ->setTitle($faker->words(rand(5, 10), true))
                ->setContent($faker->text())
                ->setImage($image)
                ->setAuthor($faker->name())
                ->setIsHidden($bool[rand(0, 1)])
                ->setCreatedAt(DateTimeImmutable::createFromMutable($date));

            $manager->persist($news);
        }

        $manager->flush();
    }
}
