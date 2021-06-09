<?php

declare(strict_types=1);

namespace Auth\Infrastructure\QueryService\Dummy;

use Auth\Application\Dto\UserDto;
use Auth\Domain\Models\User\UserQueryService;

/**
 * Class DummyUserQueryService
 *
 * @package Auth\Infrastructure\QueryService\Dummy
 */
final class DummyUserQueryService implements UserQueryService
{
    /**
     * @param string|null $id
     * @param string|null $name
     * @param string|null $email
     *
     * @return UserDto[]
     */
    public function invoke(?string $id = null, ?string $name = null, ?string $email = null): array
    {
        return [new UserDto($id ?? 'dummy-dummy-dummy-dummy', $name ?? 'dummyName', $email ?? 'dummy@dummy.dummy')];
    }
}
