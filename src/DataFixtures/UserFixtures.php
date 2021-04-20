<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    private UserPasswordEncoderInterface $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin->setEmail('admin@test.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->userPasswordEncoder->encodePassword($admin, 'password'));
        
            $manager->persist($admin);
            
        for ($i = 0; $i < 10; $i++) {
            $user = (new User())
                ->setEmail(sprintf('user%d@test.com', $i));

            $user->setPassword($this->userPasswordEncoder->encodePassword($user, 'password'));

            $manager->persist($user);
        }

        $manager->flush();
    }
}
