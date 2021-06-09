<?php

declare(strict_types=1);

namespace Auth\Domain\Models\User;

use Auth\Application\Dto\UserDto;

/**
 * Interface UserQueryService
 *
 * @package Auth\Domain\Models\User
 */
interface UserQueryService
{
    /**
     * @param string|null $id
     * @param string|null $name
     * @param string|null $email
     *
     * @return UserDto[]
     */
    public function invoke(?string $id = null, ?string $name = null, ?string $email = null): array;
}
