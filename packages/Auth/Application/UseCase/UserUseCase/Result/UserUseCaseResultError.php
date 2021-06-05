<?php

declare(strict_types=1);

namespace Auth\Application\UseCase\UserUseCase\Result;

use Basic\UseCaseSupport\UseCaseError;

/**
 * @method static NOT_FOUND()
 * @method static DUPLICATION_ID()
 * @method static DUPLICATION_EMAIL()
 * @method static PASSWORD_ENCRYPT()
 */
final class UserUseCaseResultError extends UseCaseError
{
    const NOT_FOUND = 0;
    const DUPLICATION_ID = 1;
    const DUPLICATION_EMAIL = 2;
    const PASSWORD_ENCRYPT = 3;
}
