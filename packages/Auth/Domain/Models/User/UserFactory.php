<?php

declare(strict_types=1);

namespace Auth\Domain\Models\User;

use Auth\Domain\Models\User\ValueObject\UserEmail;
use Auth\Domain\Models\User\ValueObject\UserId;
use Auth\Domain\Models\User\ValueObject\UserName;
use Auth\Domain\Models\User\ValueObject\UserPassword;
use Basic\DomainSupport\Domain\Domain;
use Basic\DomainSupport\Domain\Factory;
use Basic\DomainSupport\Domain\Uuid;

/**
 * Class UserFactory
 *
 * @package Auth\Domain\Models\User
 */
final class UserFactory implements Factory
{
    /**
     * @var \Basic\DomainSupport\Domain\Uuid
     */
    private Uuid $uuid;

    /**
     * UserFactory constructor.
     *
     * @param \Basic\DomainSupport\Domain\Uuid $uuid
     */
    public function __construct(Uuid $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @param object $object
     *
     * @return \Basic\DomainSupport\Domain\Domain
     * @throws \Exception
     */
    public function request(object $object): Domain
    {
        $object->id =  $this->uuid->generate();
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
    public function db(object $object): Domain
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

        if (!empty($hiddenOption)) {
            return array_filter(
                $array,
                function ($value, string $key) use ($hiddenOption) {
                    foreach ($hiddenOption as $option) {
                        return $option !== $key;
                    }
                },
                ARRAY_FILTER_USE_BOTH
            );
        }

        return $array;
    }
}
