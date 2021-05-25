<?php

declare(strict_types=1);

namespace Basic\DomainSupport\ValueObjects;

/**
 * 識別子オブジェクト
 *
 * Class Identifier
 *
 * @package Basic\DomainSupport\ValueObjects
 */
abstract class Identifier extends StringValueObject
{
    /**
     * 生成パターン
     */
    const PATTERN = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx';

    /**
     * UUID 生成
     *
     * @return string
     * @throws \Exception
     */
    public static function generate(): string
    {
        $chars = str_split(self::PATTERN);

        foreach ($chars as $i => $char) {
            if ($char === 'x') {
                $chars[$i] = dechex(random_int(0, 15));
            } elseif ($char === 'y') {
                $chars[$i] = dechex(random_int(8, 11));
            }
        }

        return implode('', $chars);
    }
}
