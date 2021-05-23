<?php

declare(strict_types=1);

namespace Basic\UseCaseSupport;

/**
 * Class UseCaseResult
 *
 * @package Basic\UseCaseSupport
 */
abstract class UseCaseResult
{
    /**
     * @var object|null
     */
    private ?object $resultValue;

    /**
     * @var integer|null
     */
    private ?int $errorCode;

    /**
     * UseCaseResult constructor.
     *
     * @param object|null $resultValue
     * @param integer|null    $errorCode
     */
    public function __construct(?object $resultValue, ?int $errorCode)
    {
        $this->resultValue = $resultValue;
        $this->errorCode = $errorCode;
    }

    /**
     * @param object $resultValue
     *
     * @return static
     */
    public static function success(object $resultValue): self
    {
        return new static($resultValue, null);
    }

    /**
     *
     * @param integer $useCaseError
     *
     * @return static
     */
    public static function fail(int $useCaseError): self
    {
        return new static(null, $useCaseError);
    }

    /**
     * @return object|null
     */
    public function getResultValue(): ?object
    {
        return $this->resultValue;
    }

    /**
     * @return boolean
     */
    public function isError(): bool
    {
        return !is_null($this->errorCode);
    }

    /**
     * @return integer|null
     */
    public function getErrorCode(): ?int
    {
        return $this->errorCode;
    }
}
