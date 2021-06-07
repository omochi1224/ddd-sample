<?php

declare(strict_types=1);

namespace Auth\Factory;

use Auth\Domain\Models\User\User;
use Auth\Domain\Models\User\UserFactory;
use Auth\Domain\Models\User\ValueObject\UserEmail;
use Auth\Domain\Models\User\ValueObject\UserId;
use Auth\Domain\Models\User\ValueObject\UserName;
use Auth\Domain\Models\User\ValueObject\UserPassword;
use Basic\DomainSupport\Domain\Domain;
use Basic\DomainSupport\Domain\Factory;
use Basic\DomainSupport\Domain\Uuid;

final class UserDomainFactory implements UserFactory, Factory
{
    /**
     * UserFactory constructor.
     *
     * @param \Basic\DomainSupport\Domain\Uuid $uuid
     */
    public function __construct(private Uuid $uuid)
    {
    }

    /**
     * @param object $object
     *
     * @return \Auth\Domain\Models\User\User
     * @throws \Exception
     */
    public function request(object $object): User
    {
        $object->id = $this->uuid->generate();
        return new User(
            UserId::of($object->id),
            UserName::of($object->name),
            UserEmail::of($object->email),
            UserPassword::of($object->password)
        );
    }

    /**
     * @param object $object
     *
     * @return \Auth\Domain\Models\User\User
     */
    public function db(object $object): User
    {
        return new User(
            UserId::of($object->id),
            UserName::of($object->name),
            UserEmail::of($object->email),
            UserPassword::of($object->password)
        );
    }

    /**
     * @param \Basic\DomainSupport\Domain\Domain $domain
     * @param string[]                           $hiddenOption
     *
     * @return array<string, string>
     */
    public function toArray(Domain $domain, array $hiddenOption = []): array
    {
        $array = [
            'id' => $domain->getUserId()->value(),
            'name' => $domain->getUserName()->value(),
            'email' => $domain->getUserEmail()->value(),
            'password' => $domain->getUserPassword()->value(),
        ];

        return $hiddenOption !== [] ? array_filter(
            $array,
            static function ($value, string $key) use ($hiddenOption) {
                foreach ($hiddenOption as $option) {
                    return $option !== $key;
                }
            },
            ARRAY_FILTER_USE_BOTH
        ) : $array;
    }
}
