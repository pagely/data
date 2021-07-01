<?php

namespace Equip\Data\Traits;

/**
 * @method __construct(array $data = []) inherited from ImmutableValueObjectTrait
 */
trait EntityTrait
{
    use DateAwareTrait;
    use JsonAwareTrait;
    use SerializeAwareTrait;
    use ImmutableValueObjectTrait;
}
