<?php

declare(strict_types=1);

namespace Auth\Presentation\Requests;

use Basic\RequestSupport\ApiFormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UserFindRequest
 *
 * @package Auth\Presentation\Requests
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['string', 'max:255',],
            'email' => ['string', 'email', 'max:255',],
            'password' => ['string', 'min:8',],
        ];
    }
}
