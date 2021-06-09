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
     * @param User $user
     *
     * @return void
     */
    public function store(User $user): void
    {
        $this->users[$user->getUserId()->value()] = $user;
    }

    /**
     * @param UserId $userId
     *
     * @return User|null
     */
    public function findById(UserId $userId): ?User
    {
        if (!array_key_exists($userId->value(), $this->users)) {
            return null;
        }
        return $this->users[$userId->value()];
    }

    /**
     * @param UserId $userId
     *
     * @return void
     * @throws UserNotFoundException
     */
    public function delete(UserId $userId): void
    {
        if (!array_key_exists($userId->value(), $this->users)) {
            throw new UserNotFoundException();
        }
        unset($this->users[$userId->value()]);
    }

    /**
     * @param UserEmail $userEmail
     *
     * @return User|null
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

        if (count($users) === 0) {
            return null;
        }

        return $users[0];
    }
}
