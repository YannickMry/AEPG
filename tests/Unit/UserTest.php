<?php

namespace App\Tests\Unit;

use App\Entity\Member;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{

    public function testUserEntityGetterAndSetter()
    {
        $email = 'user@test.com';
        $password = 'password';
        $roles = ['ROLE_ADMIN','ROLE_USER'];

        $user = new User();

        $user->setEmail($email)
            ->setPassword($password)
            ->setRoles(['ROLE_ADMIN']);

        $this->assertInstanceOf(User::class, $user);
        $this->assertNull($user->getId());
        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals($password, $user->getPassword());
        $this->assertEquals($email, $user->getUsername());
        $this->assertEquals($roles, $user->getRoles());
        $this->assertNull($user->getSalt());
        $this->assertNull($user->eraseCredentials());
    }
}
