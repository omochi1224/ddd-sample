<?php

declare(strict_types=1);

namespace Auth\Application\UseCase\UserUseCase\Result;

final class UserUseCaseResultError
{
    const NOT_FOUND = 0;
    const DUPLICATION_ID = 1;
    const DUPLICATION_EMAIL = 2;
    const PASSWORD_ENCRYPT = 3;
}
