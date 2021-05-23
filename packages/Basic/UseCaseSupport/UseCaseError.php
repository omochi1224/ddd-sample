<?php

declare(strict_types=1);

namespace Basic\UseCaseSupport;

use InvalidArgumentException;
use ReflectionObject;

abstract class UseCaseError
{
    /**
     * @var mixed
     */
    private $scalar;

    /**
     * Enum constructor.
     *
     * @param $value
     */
    public function __construct($value)
    {
        $ref = new ReflectionObject($this);
        $constants = $ref->getConstants();
        if (!in_array($value, $constants)) {
            throw new InvalidArgumentException();
        }

        $this->scalar = $value;
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        $class = get_called_class();
        $const = constant("$class::$name");
        return new $class($const);
    }

    /**
     * @return mixed
     */
    final public function valueOf()
    {
        return $this->scalar;
    }
}
