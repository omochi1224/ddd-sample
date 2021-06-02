<?php

declare(strict_types=1);

namespace App\lib\Uuid;


use Basic\DomainSupport\Domain\Uuid;
use Illuminate\Support\Str;

/**
 * Class LaravelUuid
 *
 * @package App\lib\Uuid
 */
final class LaravelUuid implements Uuid
{
    /**
     * @return string
     */
    public function generate(): string
    {
        return (string)Str::uuid();
    }
}
