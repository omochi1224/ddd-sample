<?php

declare(strict_types=1);

namespace Auth\Infrastructure\Repositories\Eloquent;

use Auth\Domain\Exception\UserNotFoundException;
use Auth\Domain\Models\User\User;
use Auth\Domain\Models\User\UserFactory;
use Auth\Domain\Models\User\UserRepository;
use Auth\Domain\Models\User\ValueObject\UserEmail;
use Auth\Domain\Models\User\ValueObject\UserId;
use Auth\Infrastructure\Eloquent\EloquentUser;

/**
 * Class EloquentUserRepository
 *
 * @package Auth\Infrastructure\Repositories\Eloquent
 *
 */
final class EloquentUserRepository implements UserRepository
{
    /**
     * @var \Auth\Infrastructure\Eloquent\EloquentUser
     */
    private EloquentUser $eloquentUser;

    /**
     * EloquentUserRepository constructor.
     *
     * @param \Auth\Infrastructure\Eloquent\EloquentUser $eloquentUser
     */
    public function __construct(EloquentUser $eloquentUser)
    {
        $this->eloquentUser = $eloquentUser;
    }

    /**
     * @param \Auth\Domain\Models\User\User $user
     * @return void
     */
    public function store(User $user): void
    {
        $this->eloquentUser
            ->fill(UserFactory::toArray($user))
            ->save();
    }

    /**
     * @param \Auth\Domain\Models\User\ValueObject\UserId $userId
     *
     * @return \Auth\Domain\Models\User\User|null
     */
    public function findById(UserId $userId): ?User
    {
        $user = $this->eloquentUser
            ->where('id', $userId->value())
            ->first();
        if (is_null($user)) {
            return null;
        }

        /** @var User $domain */
        $domain = UserFactory::db($user);
        return $domain;
    }

    /**
     * @param \Auth\Domain\Models\User\ValueObject\UserId $userId
     *
     * @return void
     *
     * @throws \Auth\Domain\Exception\UserNotFoundException
     */
    public function delete(UserId $userId): void
    {
        $user = $this->eloquentUser
            ->where('id', $userId->value())
            ->first();
        if (is_null($user)) {
            throw new UserNotFoundException();
        }

        $this->eloquentUser
            ->where('id', $userId->value())
            ->delete();
    }

    /**
     * @param \Auth\Domain\Models\User\ValueObject\UserEmail $userEmail
     *
     * @return \Auth\Domain\Models\User\User|null
     */
    public function findByEmail(UserEmail $userEmail): ?User
    {
        $user = $this->eloquentUser->where('email', $userEmail->value())->first();
        if (is_null($user)) {
            return null;
        }

        /** @var User $domain */
        $domain = UserFactory::db($user);
        return $domain;
    }
}
