<?php

namespace EquipTests\Data\Traits;

use PHPUnit\Framework\TestCase;

class JsonAwareTest extends TestCase
{
    public function testJson()
    {
        $object = new JsonAware;

        $object->id = 1;
        $object->name = 'Test Case';

        $json = json_encode($object,  JSON_THROW_ON_ERROR);
        $data = json_decode($json, true);

        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('name', $data);

        $this->assertSame($object->id, $data['id']);
        $this->assertSame($object->name, $data['name']);

    }
}
