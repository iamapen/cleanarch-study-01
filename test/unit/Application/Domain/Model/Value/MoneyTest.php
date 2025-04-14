<?php
declare(strict_types=1);

namespace Acme\Buckpal\Test\Unit\Application\Domain\Model\Value;

use Acme\Buckpal\Application\Domain\Model\Value\Money;

class MoneyTest extends \PHPUnit\Framework\TestCase
{
    public function testAdd(): void
    {
        $money1 = Money::of(100);
        $money2 = Money::of(200);
        $result = Money::add($money1, $money2);
        $this->assertSame(300, $result->getValue());
    }

    public function testSubtract(): void
    {
        $money1 = Money::of(200);
        $money2 = Money::of(100);
        $result = Money::subtract($money1, $money2);
        $this->assertSame(100, $result->getValue());
    }

    public function testSubtract_NegativeAmount(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Negative amount is not allowed.');
        $money1 = Money::of(100);
        $money2 = Money::of(200);
        Money::subtract($money1, $money2);
    }
}
