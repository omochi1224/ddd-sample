<?php

declare(strict_types=1);

namespace Auth\Presentation\Response\Errors;

use Basic\ExceptionSupport\BaseErrorResponseException;
use Illuminate\Http\JsonResponse;

/**
 * Class NotFoundErrorResponseException
 *
 * @package Auth\Presentation\Response\Errors
 */
final class NotFoundErrorResponseException extends BaseErrorResponseException
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function toResponse($request): JsonResponse
    {
        $this->setErrorMessage('ユーザが見つかりませんでした');
        $this->setStatusCode(404);
        return parent::toResponse($request);
    }
}
