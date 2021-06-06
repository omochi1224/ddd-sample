<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Model\ValueObject;


use Auth\Domain\Models\User\ValueObject\UserEmail;
use Illuminate\Foundation\Testing\WithFaker;
use InvalidArgumentException;
use Tests\TestCase;

final class UserEmailTest extends TestCase
{
    use WithFaker;

    public function test_正しいメールアドレス()
    {
        $emailVo = UserEmail::of($email = $this->faker->email);
        self::assertEquals($email, $emailVo->value());
    }

    public function test_不正なメールアドレス()
    {
        //発生するべき例外
        $this->expectException(InvalidArgumentException::class);
        $emailVo = UserEmail::of($email = 'test@aaa@');
    }
}
