<?php

namespace EquipTests\Data\Traits;


use PHPUnit\Framework\TestCase;

class DateAwareTest extends TestCase
{
    private $object;

    protected function setUp(): void
    {
        $this->object = new DateAware;
        $this->object->at = '2015-10-30 15:05:00';
    }

    public function testDate()
    {
        $date = $this->object->date('at');
        $this->assertInstanceOf('Carbon\Carbon', $date);
    }

    public function testDateString()
    {
        $date = $this->object->dateString('at');
        $this->assertStringStartsWith('Fri, 30 Oct 2015 15:05:00 ', $date);
    }
}
