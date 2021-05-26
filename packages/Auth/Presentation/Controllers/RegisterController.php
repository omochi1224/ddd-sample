<?php

declare(strict_types=1);

namespace Auth\Presentation\Controllers;

use App\Http\Controllers\Controller;
use Auth\Application\UseCase\UserUseCase\UserRegisterUseCase;
use Auth\Domain\Models\User\UserFactory;
use Auth\Presentation\Requests\RegisterRequest;

/**
 * Class RegisterController
 *
 * @package Auth\Presentation\Controllers
 */
final class RegisterController extends Controller
{
    use ErrorResponse;

    /**
     * @var \Auth\Application\UseCase\UserUseCase\UserRegisterUseCase
     */
    private UserRegisterUseCase $useCase;

    /**
     * RegisterController constructor.
     *
     * @param \Auth\Application\UseCase\UserUseCase\UserRegisterUseCase $useCase
     */
    public function __construct(UserRegisterUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    /**
     * ユーザの登録
     *
     * @group User
     *
     * @param \Auth\Presentation\Requests\RegisterRequest $request
     *
     * @urlParam  users
     *
     * @response 200 {
     *     "id":"UUID",
     *     "name":"TestName",
     *     "email":"test@example.com"
     * }
     * @response status=422 scenario="Validation error" {
     * "errors":{
     *    "name":[
     *      "The name field is required.",
     *      "The name may not be greater than 255 characters."
     *    ],
     *    "email":[
     *      "The email field is required.",
     *      "The email must be a valid email address.",
     *      "The name may not be greater than 255 characters."
     *    ],
     *    "password":[
     *      "The name field is required.",
     *      "The password must be at least 8 characters.",
     *      "The password confirmation does not match."
     *    ]
     *  }
     * }
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function __invoke(RegisterRequest $request)
    {
        $result = $this->useCase->invoke($request->toDomain());
        if ($result->isError()) {
            return $this->errorResponse($result->getErrorCode());
        }

        /** @var \Auth\Domain\Models\User\User $user */
        $user = $result->getResultValue();
        return response()->json(UserFactory::toArray($user, ['password']));
    }
}
