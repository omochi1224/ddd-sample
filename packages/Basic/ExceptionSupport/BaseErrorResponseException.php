<?php

declare(strict_types=1);

namespace Basic\ExceptionSupport;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use RuntimeException;

/**
 * Class BaseErrorResponseException
 *
 * @package Basic\ExceptionSupport
 */
class BaseErrorResponseException extends RuntimeException implements Responsable
{
    /**
     * @var string
     */
    protected $message;

    /**
     * @var string|null
     */
    protected ?string $errorCode = null;

    /**
     * 初期エラーコード一覧
     * ステータスコードに紐付いた基本的なエラーコードで、アプリケーション固有のエラーコードは定義しない
     *
     * @var array<int, string>
     */
    protected array $defaultErrorCodes = [
        400 => 'bad_request',
        401 => 'unauthorized',
        403 => 'forbidden',
        404 => 'not_found',
        405 => 'method_not_allowed',
        422 => 'validation_error',
        500 => 'internal_server_error',
    ];

    /**
     * BaseErrorResponseException constructor.
     *
     * @param string  $message
     * @param integer $statusCode
     */
    final public function __construct(string $message = '', private int $statusCode = 500)
    {
        $this->message = $message;
    }

    /**
     * @param string $message
     */
    final public function setErrorMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return JsonResponse
     */
    public function toResponse($request): JsonResponse
    {
        return new JsonResponse(
            $this->getBasicResponse(),
            $this->getStatusCode()
        );
    }

    /**
     * @return array[]
     */
    final protected function getBasicResponse(): array
    {
        return [
            'errors' => [
                'message' => $this->getErrorMessage(),
            ]
        ];
    }

    /**
     * @return string
     */
    final public function getErrorMessage(): string
    {
        return $this->message;
    }

    /**
     * @return null|string
     */
    final public function getErrorCode(): ?string
    {
        return $this->errorCode;
    }

    /**
     * @param string $errorCode
     */
    final public function setErrorCode(string $errorCode): void
    {
        $this->errorCode = $errorCode;
    }

    /**
     * @return integer
     */
    final public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param integer $statusCode
     */
    final public function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @return string
     */
    final protected function getDefaultErrorCode(): string
    {
        return $this->defaultErrorCodes[$this->getStatusCode()];
    }
}
