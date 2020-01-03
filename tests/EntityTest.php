<?php

namespace EquipTests\Data;

use PHPUnit\Framework\TestCase;

class EntityTest extends TestCase
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @var \Equip\Data\EntityInterface
     */
    protected $entity;

    public function setUp(): void
    {
        $this->data = [
            'id'         => 42,
            'name'       => 'Life',
            'created_at' => '2015-10-31 11:10:33',
        ];

        $this->entity = new Entity($this->data);
    }

    public function testImplements()
    {
        $this->assertInstanceOf('Equip\Data\EntityInterface', $this->entity);
        $this->assertInstanceOf('JsonSerializable', $this->entity);
        $this->assertInstanceOf('Serializable', $this->entity);
    }

    public function testToArray()
    {
        $this->assertSame($this->data, $this->entity->toArray());
    }

    public function testDate()
    {
        $this->assertInstanceOf('Carbon\Carbon', $this->entity->date('created_at'));
    }

    public function testJsonEncode()
    {
        $json = json_encode($this->entity);

        $this->assertJson($json);

        $this->assertSame($this->data, json_decode($json, true));
    }

    public function testSerialize()
    {
        $frozen = serialize($this->entity);

        $this->assertIsString($frozen);

        $thawed = unserialize($frozen);

        $this->assertInstanceOf(get_class($this->entity), $thawed);
        $this->assertNotSame($this->entity, $thawed);
        $this->assertSame($this->data, $thawed->toArray());
    }
}
