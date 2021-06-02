<?php

declare(strict_types=1);

namespace Tests\Unit\QueryService;

use Auth\Domain\Models\User\UserFactory;
use Auth\Domain\Models\User\ValueObject\UserId;
use Auth\Infrastructure\Eloquent\EloquentUser;
use Auth\Infrastructure\QueryService\Eloquent\EloquentUserQueryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class UserQueryServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_invoke()
    {
        $dummyUsers = factory(EloquentUser::class, 10)->create();

        /** @var \Auth\Domain\Models\User\User[] $dummyUserDomains */
        $dummyUserDomains = $dummyUsers->map(function ($user) {
            return app(UserFactory::class)->db($user);
        });

        /** @var EloquentUserQueryService $queryService */
        $queryService = app(EloquentUserQueryService::class);

        foreach ($dummyUserDomains as $userDomain) {
            $id = $queryService->invoke($userDomain->getUserId()->value());
            self::assertEquals($id[0]->getId(), $userDomain->getUserId()->value());
            self::assertEquals($id[0]->getName(), $userDomain->getUserName()->value());
            self::assertEquals($id[0]->getEmail(), $userDomain->getUserEmail()->value());

            $name = $queryService->invoke(null, $userDomain->getUserName()->value());
            self::assertEquals($name[0]->getId(), $userDomain->getUserId()->value());
            self::assertEquals($name[0]->getName(), $userDomain->getUserName()->value());
            self::assertEquals($name[0]->getEmail(), $userDomain->getUserEmail()->value());


            $email = $queryService->invoke(null, null, $userDomain->getUserEmail()->value());
            self::assertEquals($email[0]->getId(), $userDomain->getUserId()->value());
            self::assertEquals($email[0]->getName(), $userDomain->getUserName()->value());
            self::assertEquals($email[0]->getEmail(), $userDomain->getUserEmail()->value());
        }
    }
}
