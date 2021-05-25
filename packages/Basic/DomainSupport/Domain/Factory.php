<?php

declare(strict_types=1);

namespace Basic\DomainSupport\Domain;

/**
 * Interface Factory
 *
 * @package Basic\DomainSupport\Domain
 */
interface Factory
{
    /**
     * @param object $object
     *
     * @return \Basic\DomainSupport\Domain\Domain
     */
    public static function request(object $object): Domain;

    /**
     * @param object $object
     *
     * @return \Basic\DomainSupport\Domain\Domain
     */
    public static function db(object $object): Domain;

    /**
     * @param \Basic\DomainSupport\Domain\Domain $domain
     * @param string[]                           $hiddenOption 隠したい配列のキーを記述
     *
     * @return array<mixed>
     */
    public static function toArray(Domain $domain, array $hiddenOption = []): array;
}
