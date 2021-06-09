<?php

declare(strict_types=1);

namespace Auth\Presentation\Controllers;

use App\Http\Controllers\Controller;
use Auth\Application\UseCase\UserUseCase\Result\UserUseCaseResultError;
use Auth\Application\UseCase\UserUseCase\UserRegisterUseCase;
use Auth\Domain\Models\User\User;
use Auth\Domain\Models\User\UserFactory;
use Auth\Presentation\Requests\RegisterRequest;
use Auth\Presentation\Response\Errors\DuplicationEmailErrorResponseException;
use Auth\Presentation\Response\Errors\DuplicationIdErrorResponseException;
use Auth\Presentation\Response\Errors\NotFoundErrorResponseException;
use Basic\ExceptionSupport\BaseErrorResponseException;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * Class RegisterController
 *
 * @package Auth\Presentation\Controllers
 */
final class RegisterController extends Controller
{
    /**
     * @var UserRegisterUseCase
     */
    private UserRegisterUseCase $useCase;

    /**
     * @var UserFactory
     */
    private UserFactory $userFactory;

    /**
     * RegisterController constructor.
     *
     * @param UserRegisterUseCase $useCase
     * @param UserFactory         $userFactory
     */
    public function __construct(UserRegisterUseCase $useCase, UserFactory $userFactory)
    {
        $this->useCase = $useCase;
        $this->userFactory = $userFactory;
    }

    /**
     * ユーザの登録
     *
     * @group     User
     *
     * @param RegisterRequest $request
     *
     * @urlParam  users
     *
     * @response  200 {
     *     "id":"UUID",
     *     "name":"TestName",
     *     "email":"test@example.com"
     * }
     * @response  status=422 scenario="Validation error" {
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
     * @response  status=409 scenario="Validation error" {
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
     * @return JsonResponse
     * @throws Exception
     */
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $result = $this->useCase->invoke($request->toDomain());
        if ($result->isError()) {
            match ($result->getErrorCode()) {
                default => throw new BaseErrorResponseException(),
                UserUseCaseResultError::NOT_FOUND => throw new NotFoundErrorResponseException(),
                UserUseCaseResultError::DUPLICATION_ID => throw new DuplicationIdErrorResponseException(),
                UserUseCaseResultError::DUPLICATION_EMAIL => throw new DuplicationEmailErrorResponseException(),
            };
        }

        /** @var User $user */
        $user = $result->getResultValue();
        return response()->json($this->userFactory->toArray($user, ['password']));
    }
}
