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
     * @param \Auth\Presentation\Requests\RegisterRequest $request
     *
     * @return \Illuminate\Http\JsonResponse|string[]
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
        return UserFactory::toArray($user, ['password']);
    }
}
