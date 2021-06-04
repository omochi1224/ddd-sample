<?php

declare(strict_types=1);

namespace Basic\DomainSupport\ValueObjects;

use Basic\DomainSupport\Exception\InvariantException;

/**
 * 正数オブジェクト
 *
 * Class PositiveNumber
 *
 * @package Basic\DomainSupport\ValueObjects
 */
abstract class PositiveNumber
{
    /** @var integer */
    protected int $value;

    /**
     * @param integer $value
     *
     * @throws InvariantException
     */
    private function __construct(int $value = 0)
    {
        if ($value < 0) {
            throw new InvariantException('value must be positive number:' . $value);
        }
        $this->value = $value;
    }

    /**
     * @param integer $value
     *
     * @return static
     * @throws \Basic\DomainSupport\Exception\InvariantException
     */
    public static function of(int $value = 0): static
    {
        return new static($value);
    }

    /**
     * @return integer
     */
    public function value(): int
    {
        return $this->value;
    }
}
