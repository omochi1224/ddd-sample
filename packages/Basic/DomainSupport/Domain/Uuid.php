<?php

declare(strict_types=1);

namespace Basic\DomainSupport\Domain;

interface Uuid
{
    /**
     * UUID生成
     *
     * @return string uuid
     */
    public function generate(): string;
}
