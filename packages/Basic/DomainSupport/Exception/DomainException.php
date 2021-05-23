<?php

declare(strict_types=1);

namespace Basic\DomainSupport\Exception;

use Exception;

/**
 * Class DomainException
 *
 * @package Basic\DomainSupport\Exception
 */
abstract class DomainException extends Exception
{
    /**
     * @var string
     */
    protected $message = 'ドメインで例外が発生しました。';
}
