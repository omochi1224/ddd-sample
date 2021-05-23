<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Auth;


use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

final class UserFindControllerTest extends TestCase
{
    use WithFaker;

    public function test_ユーザ検索()
    {
        $name = $this->faker->name;

        $response = $this->get(route('user.find', [
            'name' => $name
        ]));

        $response->assertJsonFragment(['name' => $name]);
    }

}
