<?php

declare(strict_types=1);

namespace Auth\Presentation\Controllers;

use App\Http\Controllers\Controller;
use Auth\Application\UseCase\UserUseCase\UserFindUseCase;
use Auth\Presentation\Requests\UserFindRequest;
use Illuminate\Http\JsonResponse;

/**
 * Class UserFindController
 *
 * @package Auth\Presentation\Controllers
 */
final class UserFindController extends Controller
{
    use ErrorResponse;

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
     * @group User
     *
     * @param \Auth\Presentation\Requests\UserFindRequest $request
     * @urlParam  users
     * @response 200 {
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
            return $this->errorResponse($result->getErrorCode());
        }

        return response()->json((array)$result->getResultValue());
    }
}
