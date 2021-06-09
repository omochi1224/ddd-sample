<?php

declare(strict_types=1);

namespace Auth\Presentation\Requests;

use Auth\Domain\Models\User\User;
use Auth\Domain\Models\User\UserFactory;
use Basic\DomainSupport\Domain\Domainable;
use Basic\RequestSupport\ApiFormRequestTrait;
use Exception;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class RegisterRequest
 *
 * @package   Auth\Presentation\Requests
 * @bodyParam name required 名前 Example:testName
 * @bodyParam email required メールアドレス Example:example@example.com
 * @bodyParam password required パスワード Example:Passw0rd!
 * @bodyParam password_confirmation required 確認用パスワード Example:Passw0rd!
 */
final class RegisterRequest extends FormRequest implements Domainable
{
    use ApiFormRequestTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<string>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255',],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    /**
     * API仕様書で参照されるリクエスト
     *
     * @return string[][]
     */
    public function bodyParameters(): array
    {
        return [
            'name' => [
                'description' => 'ユーザ名',
                'example' => 'テスト名前',
            ],
            'email' => [
                'description' => 'メールアドレス',
                'example' => 'example@examp.com',
            ],
            'password' => [
                'description' => 'パスワード',
                'example' => 'Passw0rd!',
            ],
            'password_confirmation' => [
                'description' => 'パスワード確認',
                'example' => 'Passw0rd!',
            ],
        ];
    }

    /**
     * @return User
     * @throws Exception
     */
    public function toDomain(): User
    {
        /** @var UserFactory $factory */
        $factory = app(UserFactory::class);
        return $factory->request($this);
    }
}
