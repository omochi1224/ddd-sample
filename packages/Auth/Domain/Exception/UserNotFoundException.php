<?php

declare(strict_types=1);

namespace Auth\Domain\Exception;

use Basic\DomainSupport\Exception\DomainException;

/**
 * Class UserNotFoundException
 *
 * @package Auth\Domain\Exception
 */
final class UserNotFoundException extends DomainException
{
    /**
     * @var string
     */
    protected $message = 'ユーザが見つかりませんでした。';
}
