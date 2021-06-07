<?php

declare(strict_types=1);

namespace Basic\DomainSupport\Domain;

/**
 * DomainFactoryについては基本的にこれをimplementsしてください
 *
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
    public function request(object $object): Domain;

    /**
     * @param object $object
     *
     * @return \Basic\DomainSupport\Domain\Domain
     */
    public function db(object $object): Domain;

    /**
     * @param \Basic\DomainSupport\Domain\Domain $domain       domainInterfaceをimplementしてるDomainModel
     * @param string[]                           $hiddenOption 隠したい配列のキーを記述
     *
     * @return array<string, mixed>
     */
    public function toArray(Domain $domain, array $hiddenOption = []): array;
}
