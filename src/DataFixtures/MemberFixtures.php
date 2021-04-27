<?php

namespace App\DataFixtures;

use App\Entity\Member;
use App\Entity\Promotion;
use App\Repository\PromotionRepository;
use Cocur\Slugify\Slugify;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class MemberFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $slugify = new Slugify();
        $faker = Factory::create('fr_FR');
        $genders = ['male', 'female'];
        $bool = [true, false];

        /** @var Promotion[] $promotions */
        $promotions = $manager->getRepository(Promotion::class)->findAll();

        foreach ($promotions as $promotion) {
            for ($i = 0; $i < 25; $i++) {
                $lastname = $faker->lastName;
                $gender = $genders[rand(0, 1)];
                $firstname = $faker->firstName($gender);
                $picture = sprintf(
                    'https://randomuser.me/api/portraits/%s/%d.jpg',
                    ($gender === 'male' ? 'men' : 'women'),
                    rand(1, 99)
                );

                $member = (new Member())
                    ->setLastname($lastname)
                    ->setFirstname($firstname)
                    ->setEmail(
                        sprintf(
                            '%s.%s@test.com',
                            strtolower($slugify->slugify($lastname)),
                            strtolower($slugify->slugify($firstname))
                        )
                    )
                    ->setPicture($picture)
                    ->setFacebookLink(rand(0, 3) === 1 ? 'facebook' : null)
                    ->setLinkedinLink(rand(0, 1) === 1 ? 'linkedin' : null)
                    ->setisDisplayed(rand(0, 6) === 1 ? $bool[0] : $bool[1])
                    ->setPromotion($promotion)
                    ->setCreatedAt(new DateTimeImmutable())
                    ->setUpdatedAt(new DateTimeImmutable());
                $manager->persist($member);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [PromotionFixtures::class];
    }
}
