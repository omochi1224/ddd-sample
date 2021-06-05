<?php

declare(strict_types=1);

namespace Basic\UseCaseSupport;

use Basic\DomainSupport\ValueObjects\Enum;

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
     * @param object|null                                 $resultValue
     * @param \Basic\DomainSupport\ValueObjects\Enum|null $errorCode
     */
    public function __construct(?object $resultValue, ?Enum $errorCode)
    {
        $this->resultValue = $resultValue;
        $this->errorCode = $errorCode?->value();
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
     * @param \Basic\DomainSupport\ValueObjects\Enum $useCaseError
     *
     * @return static
     */
    public static function fail(Enum $useCaseError): self
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
