<?php

declare(strict_types=1);

namespace Auth\Presentation\Response\Errors;

use Basic\ExceptionSupport\BaseErrorResponseException;
use Illuminate\Http\JsonResponse;

/**
 * Class DuplicationEmailErrorResponseException
 *
 * @package Auth\Presentation\Response
 */
final class DuplicationEmailErrorResponseException extends BaseErrorResponseException
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function toResponse($request): JsonResponse
    {
        $this->setErrorMessage('すでに登録済みのメールアドレスです');
        $this->setStatusCode(409);
        return parent::toResponse($request);
    }
}
