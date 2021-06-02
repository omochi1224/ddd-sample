<?php

declare(strict_types=1);

namespace Basic\DomainSupport\ValueObjects;

use Basic\DomainSupport\Exception\InvalidUuidException;

/**
 * 識別子オブジェクト
 *
 * Class Identifier
 *
 * @package Basic\DomainSupport\ValueObjects
 */
abstract class Identifier extends StringValueObject
{
    /**
     * @var string
     */
    private string $pattern = '/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i';

    /**
     * Identifier constructor.
     *
     * @param string $uuid
     *
     * @throws \Basic\DomainSupport\Exception\InvalidUuidException
     */
    public function __construct(string $uuid)
    {
        if (preg_match($this->pattern, $uuid) !== 1) {
            throw new InvalidUuidException();
        }
        $this->value = $uuid;
    }
}
