<?php

declare(strict_types=1);

namespace Basic\DomainSupport\ValueObjects;

/**
 * 文字列オブジェクト
 *
 * Class StringValueObject
 *
 * @package Basic\DomainSupport\ValueObjects
 *
 */
abstract class StringValueObject
{
    /**
     * Identifier constructor.
     *
     * @param string $value
     */
    private function __construct(protected string $value)
    {
    }

    /**
     * @param string $value
     *
     * @return static
     */
    public static function of(string $value): static
    {
        return new static($value);
    }

    /**
     * @param StringValueObject $stringValueObject
     *
     * @return boolean
     */
    public function equals(StringValueObject $stringValueObject): bool
    {
        return $this->value === $stringValueObject->value();
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }
}
