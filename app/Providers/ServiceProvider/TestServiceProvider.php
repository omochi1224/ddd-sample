<?php

declare(strict_types=1);

namespace App\Providers\ServiceProvider;

use App\lib\Hash\LaravelUserPasswordHasher;
use App\lib\Logger\LaravelLogger;
use App\lib\Transaction\LaravelDbTransaction;
use App\lib\Uuid\LaravelUuid;
use Auth\Domain\Models\User\UserQueryService;
use Auth\Domain\Models\User\UserRepository;
use Auth\Domain\Services\UserPasswordHasher;
use Auth\Infrastructure\QueryService\Dummy\DummyUserQueryService;
use Auth\Infrastructure\Repositories\Dummy\DummyUserRepository;
use Basic\DomainSupport\Domain\Uuid;
use Basic\LoggerSupport\Logger;
use Basic\Transaction\Transaction;
use Illuminate\Contracts\Foundation\Application;

/**
 * テスト用IoC
 *
 * Class TestServiceProvider
 *
 * @package App\Providers\ServiceProvider
 */
final class TestServiceProvider implements Provider
{
    /**
     * @var Application
     */
    private Application $app;

    /**
     * LocalServiceProvider constructor.
     *
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        $this->app = $application;
    }

    /**
     * FWと実装の登録処理
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerLibrary();
        $this->registerFactory();
        $this->registerRepositories();
        $this->registerQueryService();
    }

    /**
     * LibraryのIoc
     *
     * @return void
     */
    public function registerLibrary(): void
    {
        $this->app->bind(Transaction::class, LaravelDbTransaction::class);
        $this->app->bind(UserPasswordHasher::class, LaravelUserPasswordHasher::class);
        $this->app->bind(Uuid::class, LaravelUuid::class);
        $this->app->bind(Logger::class, LaravelLogger::class);
    }

    /**
     * @return void
     */
    public function registerFactory(): void
    {
    }

    /**
     * RepositoryのIoc
     *
     * @return void
     */
    public function registerRepositories(): void
    {
        $this->app->bind(UserRepository::class, DummyUserRepository::class);
    }

    /**
     * @return void
     */
    public function registerQueryService(): void
    {
        $this->app->bind(UserQueryService::class, DummyUserQueryService::class);
    }

    /**
     * ブート処理
     *
     * @return void
     */
    public function boot(): void
    {
    }
}
