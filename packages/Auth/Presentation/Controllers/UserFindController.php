<?php

declare(strict_types=1);

namespace Auth\Presentation\Controllers;

use App\Http\Controllers\Controller;
use Auth\Application\UseCase\UserUseCase\UserFindUseCase;
use Auth\Presentation\Requests\UserFindRequest;

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
     * @param \Auth\Presentation\Requests\UserFindRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(UserFindRequest $request)
    {
        $result = $this->useCase->invoke($request->id, $request->name, $request->email);

        if ($result->isError()) {
            return $this->errorResponse($result->getErrorCode());
        }

        return response()->json((array)$result->getResultValue());
    }
}
