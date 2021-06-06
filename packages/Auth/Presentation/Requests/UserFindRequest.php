<?php

declare(strict_types=1);

namespace Auth\Presentation\Requests;

use Basic\RequestSupport\ApiFormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UserFindRequest
 *
 * @queryParam id ユーザID Example: 91849582-bdf9-11eb-8529-0242ac130003
 * @queryParam name ユーザ名 Example: TestName
 * @queryParam email メールアドレス Example: test@example.com
 *
 * @package    Auth\Presentation\Requests
 */
final class UserFindRequest extends FormRequest
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
     * @return array<string, array<string>>
     */
    public function rules()
    {
        return [
            'id' => ['string', 'uuid'],
            'name' => ['string', 'max:255',],
            'email' => ['string', 'email', 'max:255',],
        ];
    }
}
