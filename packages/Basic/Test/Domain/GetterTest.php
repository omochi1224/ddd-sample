<?php

declare(strict_types=1);

namespace Basic\Test\Domain;


use Auth\Domain\Models\User\ValueObject\UserId;
use Basic\DomainSupport\Domain\Getter;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * Class GetterTest
 *
 * @package Basic\Test\Domain
 */
final class GetterTest extends TestCase
{
    public function test()
    {

        $id = (string)Str::uuid();

        $getter = new class($id) {
            use Getter;

            private UserId $userId;

            public function __construct(string $id)
            {
                $this->userId = UserId::of($id);
            }
        };

        self::assertEquals($id, $getter->getUserId()->value());
    }
}
