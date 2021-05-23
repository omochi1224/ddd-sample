<?php

declare(strict_types=1);

namespace Basic\DomainSupport\ValueObjects;

abstract class IntValueObject
{
    /**
     * @var integer
     */
    protected $value;

    /**
     * Identifier constructor.
     *
     * @param integer $value
     */
    private function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * @param integer $value
     *
     * @return static
     */
    public static function of(int $value): self
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
