<?php

declare(strict_types=1);

namespace App\lib\Transaction;

use Basic\Transaction\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class LaravelDbTransaction
 *
 * @package App\lib\Transaction
 */
final class LaravelDbTransaction implements Transaction
{
    /**
     * @param callable $transactionScope
     *
     * @return object|null
     * @throws \Throwable
     */
    public function scope(callable $transactionScope): ?object
    {
        Log::info('トランザクション');
        return DB::transaction($transactionScope);
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function begin(): void
    {
        Log::info('トランザクション開始');
        DB::beginTransaction();
    }

    /**
     * @return mixed|void
     */
    public function commit(): void
    {
        Log::info('トランザクション終了');
        DB::commit();
    }

    /**
     * @return mixed|void
     * @throws \Exception
     */
    public function rollback(): void
    {
        Log::info('ロールバック');
        DB::rollBack();
    }
}
