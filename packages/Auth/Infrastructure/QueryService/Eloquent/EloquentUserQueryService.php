<?php

declare(strict_types=1);

namespace Auth\Infrastructure\QueryService\Eloquent;

use Auth\Application\Dto\UserDto;
use Auth\Domain\Models\User\UserQueryService;
use Auth\Infrastructure\Eloquent\EloquentUser;

/**
 * Class EloquentUserQueryService
 *
 * @package Auth\Infrastructure\QueryService\Eloquent
 */
final class EloquentUserQueryService implements UserQueryService
{
    /**
     * @var \Auth\Infrastructure\Eloquent\EloquentUser
     */
    private EloquentUser $eloquentUser;

    /**
     * EloquentUserQueryService constructor.
     *
     * @param \Auth\Infrastructure\Eloquent\EloquentUser $eloquentUser
     */
    public function __construct(EloquentUser $eloquentUser)
    {
        $this->eloquentUser = $eloquentUser;
    }

    /**
     * @param string|null $id
     * @param string|null $name
     * @param string|null $email
     *
     * @return UserDto[]
     */
    public function invoke(
        ?string $id = null,
        ?string $name = null,
        ?string $email = null
    ): array {
        return $this->eloquentUser
            ->when(
                !is_null($id),
                function ($query) use ($id) {
                    return $query->where('id', $id);
                }
            )
            ->when(
                !is_null($name),
                function ($query) use ($name) {
                    return $query->where('name', 'like', "%$name%");
                }
            )
            ->when(
                !is_null($email),
                function ($query) use ($email) {
                    return $query->where('email', $email);
                }
            )
            ->get()
            ->map(
                function ($user) {
                    return new UserDto($user->id, $user->name, $user->email);
                }
            )
            ->toArray();
    }
}
