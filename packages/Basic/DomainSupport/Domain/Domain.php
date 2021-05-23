<?php

declare(strict_types=1);

namespace Basic\DomainSupport\Domain;

/**
 * Class Domain
 *
 * @package Basic\DomainSupport\Domain
 */
abstract class Domain
{
    /**
     * @param string $str
     *
     * @return string|string[]
     */
    public function convCamelize(string $str)
    {
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $str)));
    }

    /**
     * @param string $str
     *
     * @return string
     */
    public function convSnake(string $str): string
    {
        return strtolower(preg_replace('/[A-Z]/', '_$0', lcfirst($str)));
    }
}
