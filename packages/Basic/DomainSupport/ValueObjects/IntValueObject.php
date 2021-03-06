<?php

declare(strict_types=1);

namespace Basic\DomainSupport\ValueObjects;

/**
 * 数値基本オブジェクト
 *
 * Class IntValueObject
 *
 * @package Basic\DomainSupport\ValueObjects
 */
abstract class IntValueObject
{
    /**
     * Identifier constructor.
     *
     * @param integer $value
     */
    private function __construct(protected int $value)
    {
    }

    /**
     * @param integer $value
     *
     * @return static
     */
    public static function of(int $value): static
    {
        return new static($value);
    }

    /**
     * @param StringValueObject $intValueObject
     *
     * @return boolean
     */
    public function equals(StringValueObject $intValueObject): bool
    {
        return $this->value === $intValueObject->value();
    }

    /**
     * @return integer
     */
    public function value(): int
    {
        return $this->value;
    }
}
