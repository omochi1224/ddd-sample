<?php

declare(strict_types=1);

namespace Basic\Transaction;

/**
 * Interface Transaction
 *
 * @package Basic\Transaction
 */
interface Transaction
{
    /**
     * @param callable $transactionScope
     *
     * @return mixed
     */
    public function scope(callable $transactionScope): ?object;

    /**
     * @return mixed
     */
    public function begin();

    /**
     * @return mixed
     */
    public function commit();

    /**
     * @return mixed
     */
    public function rollback();
}
