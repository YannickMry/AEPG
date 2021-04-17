<?php

namespace App\Tests\Repository;

use App\Entity\Member;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserTest extends KernelTestCase
{
    public function testCount()
    {
        self::bootKernel();
        $users = self::$container->get(UserRepository::class)->count([]);

        $this->assertEquals(10, $users);
    }

    public function testUpgradePassword()
    {
        self::bootKernel();

        /** @var UserRepository $userRepository */
        $userRepository = self::$container->get(UserRepository::class);

        $user = $userRepository->findOneById(1);

        $this->assertInstanceOf(UserInterface::class, $user);

        /** @var UserPasswordEncoderInterface $userPasswordEncoder */
        $userPasswordEncoder = self::$container->get(UserPasswordEncoderInterface::class);

        $userRepository->upgradePassword($user, $userPasswordEncoder->encodePassword($user, 'password'));
    }
}
