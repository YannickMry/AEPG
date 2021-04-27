<?php

namespace App\Tests\Unit;

use App\Entity\Member;
use App\Entity\Promotion;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class MemberTest extends TestCase
{
    private const LASTNAME = 'MAURY';
    private const FIRSTNAME = 'Yannick';
    private const EMAIL = 'maury.yannick@gmail.com';
    private const CURRENT_JOB = 'dev';
    private const FACEBOOK_LINK = 'https://facebook.com';
    private const LINKEDIN_LINK = 'https://linkedin.com';
    private const PICTURE = 'image.png';
    private const IS_DISPLAYED = true;

    public function testMemberEntityGetterAndSetter()
    {
        $promotion = new Promotion();

        $createdAt = new DateTimeImmutable('now');
        $updatedAt = new DateTimeImmutable('tomorrow');

        $member = new Member();
        $member->setLastname(self::LASTNAME)
            ->setFirstname(self::FIRSTNAME)
            ->setEmail(self::EMAIL)
            ->setCurrentJob(self::CURRENT_JOB)
            ->setFacebookLink(self::FACEBOOK_LINK)
            ->setLinkedinLink(self::LINKEDIN_LINK)
            ->setPicture(self::PICTURE)
            ->setisDisplayed(self::IS_DISPLAYED)
            ->setCreatedAt($createdAt)
            ->setUpdatedAt($updatedAt)
            ->setPromotion($promotion);

        $this->assertInstanceOf(Member::class, $member);
        $this->assertEquals(null, $member->getId());
        $this->assertEquals(self::LASTNAME, $member->getLastname());
        $this->assertEquals(self::FIRSTNAME, $member->getFirstname());
        $this->assertEquals(self::EMAIL, $member->getEmail());
        $this->assertEquals(self::CURRENT_JOB, $member->getCurrentJob());
        $this->assertEquals(self::FACEBOOK_LINK, $member->getFacebookLink());
        $this->assertEquals(self::LINKEDIN_LINK, $member->getLinkedinLink());
        $this->assertEquals(self::PICTURE, $member->getPicture());
        $this->assertEquals(self::IS_DISPLAYED, $member->getisDisplayed());
        $this->assertEquals($createdAt, $member->getCreatedAt());
        $this->assertEquals($updatedAt, $member->getUpdatedAt());
        $this->assertEquals($promotion, $member->getPromotion());
    }
}
