<?php

namespace EquipTests\Data\Traits;

use PHPUnit\Framework\TestCase;

class SerializeAwareTest extends TestCase
{
    public function testSerialize()
    {
        $object = new SerializeAware;

        $object->id = 1;
        $object->name = 'Test Case';

        $frozen = serialize($object);

        $this->assertIsString($frozen);

        $thawed = unserialize($frozen);

        $this->assertNotSame($object, $thawed);

        $this->assertSame($object->id, $thawed->id);
        $this->assertSame($object->name, $thawed->name);
    }
}
