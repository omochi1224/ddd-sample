<?php

declare(strict_types=1);

namespace Basic\DomainSupport\Domain;

use Exception;

/**
 * Trait Getter
 *
 * @package Basic\DomainSupport\Domain
 */
trait Getter
{
    /**
     * Getterはここでまとめる
     *
     * @param string $name
     * @param mixed  $args
     *
     * @return mixed
     * @throws \Exception
     */
    public function __call(string $name, $args)
    {
        $propertyName = lcfirst(str_replace('get', '', $name));
        if (!property_exists($this, $propertyName)) {
            throw new Exception("Call to undefined method $name");
        }
        return $this->$propertyName;
    }
}
