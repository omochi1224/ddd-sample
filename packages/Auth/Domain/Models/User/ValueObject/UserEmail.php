<?php

declare(strict_types=1);

namespace Auth\Domain\Models\User\ValueObject;

use Basic\DomainSupport\ValueObjects\StringValueObject;
use InvalidArgumentException;

/**
 * Class UserEmail
 *
 * @package Auth\Domain\Models\User\ValueObject
 */
final class UserEmail extends StringValueObject
{
    /**
     * UserEmail constructor.
     *
     * @param string $email
     */
    public function __construct(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('The email must be a valid email address.');
        }

        $this->value = $email;
    }
}
