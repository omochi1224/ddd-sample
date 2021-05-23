<?php

declare(strict_types=1);

namespace Auth\Domain\Models\User;

use Auth\Domain\Models\User\ValueObject\UserEmail;
use Auth\Domain\Models\User\ValueObject\UserId;
use Auth\Domain\Models\User\ValueObject\UserName;
use Auth\Domain\Models\User\ValueObject\UserPassword;
use Basic\DomainSupport\Domain\Domain;
use Basic\DomainSupport\Domain\Factory;

/**
 * Class UserFactory
 *
 * @package Auth\Domain\Models\User
 */
final class UserFactory implements Factory
{
    /**
     * @param object $object
     *
     * @return \Basic\DomainSupport\Domain\Domain
     * @throws \Exception
     */
    public static function request(object $object): Domain
    {
        $object->id = UserId::generate();
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
     * @return \Basic\DomainSupport\Domain\Domain
     */
    public static function db(object $object): Domain
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
     * @param array                              $hiddenOption
     *
     * @return string[]
     */
    public static function toArray(Domain $domain, array $hiddenOption = []): array
    {
        $array = [
            'id' => $domain->getUserId()->value(),
            'name' => $domain->getUserName()->value(),
            'email' => $domain->getUserEmail()->value(),
            'password' => $domain->getUserPassword()->value(),
        ];

        if (!empty($hiddenOption)) {
            return array_filter(
                $array,
                function ($value, string $key) use ($hiddenOption) {
                    foreach ($hiddenOption as $option) {
                        return $option !== $key;
                    }
                    return [];
                },
                ARRAY_FILTER_USE_BOTH
            );
        }

        return $array;
    }
}
