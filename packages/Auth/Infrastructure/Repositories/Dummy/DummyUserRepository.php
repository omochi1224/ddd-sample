<?php

declare(strict_types=1);

namespace Auth\Infrastructure\Repositories\Dummy;

use Auth\Domain\Exception\UserNotFoundException;
use Auth\Domain\Models\User\User;
use Auth\Domain\Models\User\UserRepository;
use Auth\Domain\Models\User\ValueObject\UserEmail;
use Auth\Domain\Models\User\ValueObject\UserId;

/**
 * Class DummyUserRepository
 *
 * @package Auth\Infrastructure\Repositories\Dummy
 */
final class DummyUserRepository implements UserRepository
{
    /**
     * @var User[]
     */
    public array $users = [];

    /**
     * @param \Auth\Domain\Models\User\User $user
     * @return void
     */
    public function store(User $user): void
    {
        $this->users[$user->getUserId()->value()] = $user;
    }

    /**
     * @param \Auth\Domain\Models\User\ValueObject\UserId $userId
     *
     * @return \Auth\Domain\Models\User\User|null
     */
    public function findById(UserId $userId): ?User
    {
        if (!array_key_exists($userId->value(), $this->users)) {
            return null;
        }
        return $this->users[$userId->value()];
    }

    /**
     * @param \Auth\Domain\Models\User\ValueObject\UserId $userId
     *
     * @throws \Auth\Domain\Exception\UserNotFoundException
     * @return void
     */
    public function delete(UserId $userId): void
    {
        if (!array_key_exists($userId->value(), $this->users)) {
            throw new UserNotFoundException();
        }
        unset($this->users[$userId->value()]);
    }

    /**
     * @param \Auth\Domain\Models\User\ValueObject\UserEmail $userEmail
     *
     * @return \Auth\Domain\Models\User\User|null
     */
    public function findByEmail(UserEmail $userEmail): ?User
    {
        $users = array_filter(
            $this->users,
            function (User $user) use ($userEmail) {
                if ($user->getUserEmail()->equals($userEmail)) {
                    return $user;
                }
            }
        );

        if (empty($users)) {
            return null;
        }

        return $users[0];
    }
}
