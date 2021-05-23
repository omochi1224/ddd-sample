<?php

declare(strict_types=1);

namespace Auth\Presentation\Requests;

use Auth\Domain\Models\User\User;
use Auth\Domain\Models\User\UserFactory;
use Basic\DomainSupport\Domain\Domainable;
use Basic\RequestSupport\ApiFormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class RegisterRequest
 *
 * @package Auth\Presentation\Requests
 */
final class RegisterRequest extends FormRequest implements Domainable
{
    use ApiFormRequestTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255',],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    /**
     * @return \Auth\Domain\Models\User\User
     * @throws \Exception
     */
    public function toDomain(): User
    {
        /** @var User $user */
        $user = UserFactory::request($this);
        return $user;
    }
}
