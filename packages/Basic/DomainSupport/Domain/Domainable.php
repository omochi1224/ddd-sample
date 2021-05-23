<?php

declare(strict_types=1);

namespace Basic\DomainSupport\Domain;

/**
 * Interface Domainable
 *
 * @package Basic\DomainSupport\Domain
 */
interface Domainable
{
    /**
     * ドメインへ変換
     *
     * @return mixed
     */
    public function toDomain();
}
