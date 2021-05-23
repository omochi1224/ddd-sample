<?php

declare(strict_types=1);

namespace Basic\DomainSupport\ValueObjects;

/**
 * Class StringValueObject
 *
 * @package Basic\DomainSupport\ValueObjects
 */
abstract class StringValueObject
{
    /**
     * @var string
     */
    protected string $value;

    /**
     * Identifier constructor.
     *
     * @param string $value
     */
    private function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @param string $value
     *
     * @return static
     */
    public static function of(string $value): self
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
