<?php
declare(strict_types=1);

namespace Acme\Buckpal\Application\Domain\Model\Value;

class Money
{
    private int $amount;

    private function __construct(int $amount)
    {
        $this->amount = $amount;
    }

    public static function zero():static
    {
        return new static(0);
    }

    public static function of(int $amount): static
    {
        return new static($amount);
    }

    public static function add(Money $money1, Money $money2): Money
    {
        $amount = $money1->amount + $money2->amount;
        if ($amount < 0) {
            throw new \InvalidArgumentException('Negative amount is not allowed.');
        }
        return new Money($amount);
    }

    public static function subtract(Money $money1, Money $money2): Money
    {
        $amount = $money1->amount - $money2->amount;
        if ($amount < 0) {
            throw new \InvalidArgumentException('Negative amount is not allowed.');
        }
        return new Money($amount);
    }

    public function getValue(): int
    {
        return $this->amount;
    }

    /**
     * 金額の符号を反転させる
     * @return Money
     */
    public function negate(): Money
    {
        return new Money(-$this->amount);
    }
}
