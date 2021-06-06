<?php

declare(strict_types=1);

namespace Basic\DomainSupport\ValueObjects;


use InvalidArgumentException;
use ReflectionObject;

/**
 * Class Enum
 *
 * @package Basic\DomainSupport\ValueObjects
 */
abstract class Enum
{
    /**
     * @var mixed
     */
    private mixed $scalar;

    /**
     * Enum constructor.
     *
     * @param mixed $value
     */
    final public function __construct(mixed $value)
    {
        $ref = new ReflectionObject($this);
        $consts = $ref->getConstants();
        if (! in_array($value, $consts, true)) {
            throw new InvalidArgumentException;
        }

        $this->scalar = $value;
    }

    /**
     * @param mixed $label
     * @param mixed $args
     *
     * @return mixed
     */
    final public static function __callStatic(mixed $label, mixed $args): mixed
    {
        $class = get_called_class();
        $const = constant("$class::$label");
        return new $class($const);
    }

    /**
     * 元の値を取り出すメソッド。
     *
     * @return mixed
     */
    final public function value(): mixed
    {
        return $this->scalar;
    }

    /**
     * @return string
     */
    final public function __toString(): string
    {
        return (string)$this->scalar;
    }
}
