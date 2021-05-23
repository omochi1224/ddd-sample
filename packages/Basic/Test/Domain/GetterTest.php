<?php

declare(strict_types=1);

namespace Basic\Test\Domain;


use Auth\Domain\Models\User\ValueObject\UserId;
use Basic\DomainSupport\Domain\Getter;
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
        $getter = new class {
            use Getter;

            private UserId $userId;

            public function __construct()
            {
                $this->userId = UserId::of('test');
            }
        };

        self::assertEquals('test', $getter->getUserId()->value());
    }
}
