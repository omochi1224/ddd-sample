<?php

declare(strict_types=1);

namespace Auth\Presentation\Controllers;

use App\Http\Controllers\Controller;
use Auth\Application\UseCase\UserUseCase\Result\UserUseCaseResultError;
use Auth\Application\UseCase\UserUseCase\UserFindUseCase;
use Auth\Presentation\Requests\UserFindRequest;
use Auth\Presentation\Response\Errors\DuplicationEmailErrorResponseException;
use Auth\Presentation\Response\Errors\DuplicationIdErrorResponseException;
use Auth\Presentation\Response\Errors\NotFoundErrorResponseException;
use Basic\ExceptionSupport\BaseErrorResponseException;
use Illuminate\Http\JsonResponse;

/**
 * Class UserFindController
 *
 * @package Auth\Presentation\Controllers
 */
final class UserFindController extends Controller
{
    /**
     * @var \Auth\Application\UseCase\UserUseCase\UserFindUseCase
     */
    private UserFindUseCase $useCase;

    /**
     * UserFindController constructor.
     *
     * @param \Auth\Application\UseCase\UserUseCase\UserFindUseCase $useCase
     */
    public function __construct(UserFindUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    /**
     *　ユーザ検索
     *
     * @group     User
     *
     * @param \Auth\Presentation\Requests\UserFindRequest $request
     *
     * @urlParam  users
     * @response  200 {
     *     "id":"UUID",
     *     "name":"TestName",
     *     "email":"test@example.com"
     * }
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(UserFindRequest $request): JsonResponse
    {
        $result = $this->useCase->invoke($request->id, $request->name, $request->email);
        if ($result->isError()) {
            match ($result->getErrorCode()) {
                default => throw new BaseErrorResponseException(),
                UserUseCaseResultError::NOT_FOUND => throw new NotFoundErrorResponseException(),
                UserUseCaseResultError::DUPLICATION_ID => throw new DuplicationIdErrorResponseException(),
                UserUseCaseResultError::DUPLICATION_EMAIL => throw new DuplicationEmailErrorResponseException(),
            };
        }
        return response()->json((array)$result->getResultValue());
    }
}
