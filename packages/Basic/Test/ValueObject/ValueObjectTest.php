<?php

declare(strict_types=1);

namespace Basic\Test\ValueObject;

use Basic\DomainSupport\Exception\InvariantException;
use Basic\DomainSupport\ValueObjects\Enum;
use Basic\DomainSupport\ValueObjects\IntOnlyEnum;
use Basic\DomainSupport\ValueObjects\PositiveNumber;
use Basic\DomainSupport\ValueObjects\StringValueObject;
use Tests\TestCase;

final class ValueObjectTest extends TestCase
{
    /**
     * @test
     */
    public function String型VO()
    {
        $text = 'text';
        $stringVO = ConcreteStringValueObject::of($text);
        $this->assertEquals($text, $stringVO->value());
        $this->assertTrue($stringVO->equals(ConcreteStringValueObject::of($text)));
    }

    /**
     * @test
     */
    public function 正数型VO()
    {
        $number = 1;
        $poNum = ConcretePositiveNumberValueObject::of($number);
        self::assertEquals($number, $poNum->value());

        $number = -1;

        //マイナス値は例外が発生することを確認
        $this->expectException(InvariantException::class);
        $poNum = ConcretePositiveNumberValueObject::of($number);
    }

    /**
     * @test
     */
    public function 列挙型でオブジェクト生成()
    {
        $spade = ConcreteEnum::SPADE();
        self::assertIsObject($spade);
        self::assertEquals(ConcreteEnum::SPADE, ConcreteEnum::SPADE()->value());
    }
}

class ConcreteStringValueObject extends StringValueObject
{

}

class ConcretePositiveNumberValueObject extends PositiveNumber
{

}

class ConcreteEnum extends Enum
{
    const SPADE = 'spade';
}
