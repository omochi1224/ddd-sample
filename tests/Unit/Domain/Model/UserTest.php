<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Model;

use Auth\Domain\Models\User\User;
use Auth\Domain\Models\User\UserFactory;
use Auth\Domain\Models\User\ValueObject\UserEmail;
use Auth\Domain\Models\User\ValueObject\UserId;
use Auth\Domain\Models\User\ValueObject\UserName;
use Auth\Domain\Models\User\ValueObject\UserPassword;
use Auth\Infrastructure\Eloquent\EloquentUser;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

final class UserTest extends TestCase
{
    use WithFaker;

    public function test_生成()
    {
        $user = new User(
            UserId::of($id = UserId::generate()),
            UserName::of($name = $this->faker->userName),
            UserEmail::of($email = $this->faker->email),
            UserPassword::of($password = $this->faker->password)
        );

        self::assertEquals($id, $user->getUserId()->value());
        self::assertEquals($name, $user->getUserName()->value());
        self::assertEquals($email, $user->getUserEmail()->value());
        self::assertEquals($password, $user->getUserPassword()->value());

        //存在しないメソッドを実行するとエラーが発生することを確認
        $methodName = 'getNotFoundMethod';
        self::expectException(\Exception::class);
        self::expectExceptionMessage("Call to undefined method $methodName");
        $user->$methodName();

        //変更メソッド
        unset($name);
        $user->changeName(UserName::of($name = '変更氏名'));
        self::assertEquals($name, $user->getUserName()->value());

        unset($email);
        $user->changeEmail(UserEmail::of($email = $this->faker->email));
        self::assertEquals($email,$user->getUserEmail()->value());

        unset($password);
        $user->changePassword(UserPassword::of($password = $this->faker->password));
        self::assertEquals($password, $user->getUserPassword()->value());
    }

    public function test_変更メソッドのテスト()
    {
        $user = new User(
            UserId::of($id = UserId::generate()),
            UserName::of($name = $this->faker->userName),
            UserEmail::of($email = $this->faker->email),
            UserPassword::of($password = $this->faker->password)
        );

        $name = $this->faker->name;
        $email = $this->faker->email;
        $password = $this->faker->password;


        $user->changeEmail(UserEmail::of($email));
        $user->changeName(UserName::of($name));
        $user->changePassword(UserPassword::of($password));

        self::assertEquals($name, $user->getUserName()->value());
        self::assertEquals($email, $user->getUserEmail()->value());
        self::assertEquals($password, $user->getUserPassword()->value());
    }

    public function test_request_factory_生成()
    {
        $request = new \stdClass();
        $request->name = $this->faker->userName;
        $request->email = $this->faker->email;
        $request->password = 'password';

        $user = UserFactory::request($request);

        self::assertInstanceOf(User::class, $user);
        self::assertEquals($request->name, $user->getUserName()->value());
        self::assertEquals($request->email, $user->getUserEmail()->value());
        self::assertEquals($request->password, $user->getUserPassword()->value());
    }

    public function test_db_factory()
    {

        $eloquent = factory(EloquentUser::class)->make();
        $user = UserFactory::request($eloquent);

        self::assertInstanceOf(User::class, $user);
        self::assertEquals($eloquent->name, $user->getUserName()->value());
        self::assertEquals($eloquent->email, $user->getUserEmail()->value());
        self::assertEquals($eloquent->password, $user->getUserPassword()->value());
    }

    public function test_toArray_factory()
    {
        $eloquent = new \stdClass();
        $eloquent->id = $this->faker->uuid;
        $eloquent->name = $this->faker->userName;
        $eloquent->email = $this->faker->email;
        $eloquent->password = 'password';

        $user = UserFactory::request($eloquent);

        $userArray = UserFactory::toArray($user);
        self::assertIsArray($userArray);
        self::assertArrayHasKey('id', $userArray);
        self::assertArrayHasKey('name', $userArray);
        self::assertArrayHasKey('email', $userArray);
        self::assertArrayHasKey('password', $userArray);


        $userArray = UserFactory::toArray($user, ['password']);
        self::assertIsArray($userArray);
        self::assertArrayHasKey('id', $userArray);
        self::assertArrayHasKey('name', $userArray);
        self::assertArrayHasKey('email', $userArray);
    }
}
