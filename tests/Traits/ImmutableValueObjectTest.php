<?php

namespace EquipTests\Data\Traits;

use PHPUnit\Framework\TestCase;

class ImmutableValueObjectTest extends TestCase
{
    public function testConstruction()
    {
        $date = new \DateTime;
        $data = [
            'id'         => 1,
            'name'       => 'Jonny Jones',
            'created_at' => $date,
        ];

        $object = new ImmutableValueObject($data);

        $this->assertSame($data, $object->toArray());

        foreach (array_keys($data) as $key) {
            $this->assertTrue($object->has($key));
            $this->assertSame($data[$key], $object->$key);
        }
    }

    public function testConstructionWithUndefinedProps()
    {
        $data = [
            'id'   => 2,
            'name' => 'Fuzzy Fred',
            'skip' => true,
        ];

        $object = new ImmutableValueObject($data);

        $this->assertNotSame($data, $object->toArray());

        $this->assertTrue($object->has('id'));
        $this->assertTrue($object->has('name'));
        $this->assertFalse($object->has('skip'));
    }

    public function testConstructionSetsType()
    {
        $data = [
            'id' => '10',
            'name' => 1337,
        ];

        $object = new ImmutableValueObject($data);

        $this->assertNotSame($data, $object->toArray());

        $this->assertSame(10, $object->id);
        $this->assertSame('1337', $object->name);

        // Without type coercion, input data is exactly the same
        $object = new TypelessImmutableValueObject($data);

        $this->assertSame($data, $object->toArray());
    }

    public function testConstructionWithExpectationFailure()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessageRegExp('/expected value of .* to be an object of .* type/i');
        $data = [
            'created_at' => new \stdClass,
        ];

        $object = new ImmutableValueObject($data);
    }

    public function testValidateThrowsException()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessageRegExp('/requires a name/i');
        $object = new ImmutableValueObject([
            'id' => 5,
        ]);
    }

    public function testSetThrowsException()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessageRegExp('/modification of immutable object .* not allowed/i');
        $object = new ImmutableValueObject;
        $object->name = 'Cheery Charlie';
    }

    public function testUnsetThrowsException()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessageRegExp('/modification of immutable object .* not allowed/i');
        $object = new ImmutableValueObject;
        unset($object->name);
    }

    public function testPropertyIsSet()
    {
        $object = new ImmutableValueObject([
            'name' => 'Eager Erin',
        ]);

        $this->assertFalse(isset($object->id));
        $this->assertTrue(isset($object->name));
    }

    public function testWithData()
    {
        $data = [
            'id'   => 1,
            'name' => 'Jonny Jones',
        ];

        $object = new ImmutableValueObject($data);
        $copied = $object->withData(['name' => 'JJ']);

        $this->assertNotSame($object, $copied);

        $this->assertSame('Jonny Jones', $object->name);
        $this->assertSame('JJ', $copied->name);
    }

    public function testToArrayRecursion()
    {
        $parent = new ImmutableValueObject([
            'name' => 'Nested Nero',
        ]);

        $object = new NestedImmutableValueObject([
            'parent' => $parent,
        ]);

        $array  = $object->toArray();
        $expect = [
            'parent' => $parent->toArray(),
        ];

        $this->assertSame($expect, $array);
    }
}
