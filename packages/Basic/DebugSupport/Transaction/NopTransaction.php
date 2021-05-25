<?php

declare(strict_types=1);

namespace Basic\DebugSupport\Transaction;

use Basic\Transaction\Transaction;
use Illuminate\Support\Facades\Log;

/**
 * Class NopTransaction
 *
 * @package Basic\DebugSupport\Transaction
 */
final class NopTransaction implements Transaction
{

    /**
     * @param callable $transactionScope
     *
     * @return object|null
     */
    public function scope(callable $transactionScope): ?object
    {
        Log::info('トランザクション');
        return $transactionScope();
    }

    /**
     * @return void
     */
    public function begin(): void
    {
        Log::info('トランザクション開始');
    }

    /**
     * @return void
     */
    public function commit(): void
    {
        Log::info('トランザクション終了');
    }

    /**
     * @return void
     */
    public function rollback(): void
    {
        Log::info('ロールバック');
    }
}
