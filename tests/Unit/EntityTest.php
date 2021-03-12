<?php

namespace App\Tests\Unit;

use App\Entity\Test;
use PHPUnit\Framework\TestCase;

class EntityTest extends TestCase
{
    public function testIfAllWorking()
    {
        $test = new Test();
        $test->setTest('test');

        $this->assertEquals($test->getTest(), 'test');
        $this->assertEquals($test->getId(), null);
    }
}
