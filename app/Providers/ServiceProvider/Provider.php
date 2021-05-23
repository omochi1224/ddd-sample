<?php

declare(strict_types=1);

namespace App\Providers\ServiceProvider;

/**
 * Interface Provider
 *
 * @package App\Providers\ServiceProvider
 */
interface Provider
{
    /**
     * @return void
     */
    public function register(): void;

    /**
     * @return void
     */
    public function boot(): void;
}
