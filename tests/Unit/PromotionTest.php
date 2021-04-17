<?php

namespace App\Tests\Unit;

use App\Entity\Member;
use App\Entity\Promotion;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class PromotionTest extends TestCase
{

    public function testPromotionEntityGetterAndSetter()
    {
        $promotion = new Promotion();
        $member = new Member();
        $members = new ArrayCollection([$member]);
        $year = new DateTimeImmutable('now');

        $promotion->setYear($year)
            ->addMember($member);

        $this->assertInstanceOf(Promotion::class, $promotion);
        $this->assertEquals(null, $promotion->getId());
        $this->assertEquals($year, $promotion->getYear());
        $this->assertEquals($members, $promotion->getMembers());
        $promotion->removeMember($member);
        $this->assertCount(0, $promotion->getMembers());
    }
}
