<?php

declare(strict_types=1);

namespace Auth\Presentation\Response\Errors;


use Basic\ExceptionSupport\BaseErrorResponseException;
use Illuminate\Http\JsonResponse;

/**
 * Class DuplicationErrorResponseException
 *
 * @package Auth\Presentation\Response\Errors
 */
final class DuplicationIdErrorResponseException extends BaseErrorResponseException
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function toResponse($request): JsonResponse
    {
        $this->setErrorMessage('すでに登録済みのユーザです');
        $this->setStatusCode(409);
        return parent::toResponse($request);
    }
}
