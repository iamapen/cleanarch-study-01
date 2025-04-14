<?php
declare(strict_types=1);

namespace Acme\Buckpal\Application\Domain\Model\Value;

/**
 * 口座番号 ValueObject
 */
class AccountId
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function equals(AccountId $other): bool
    {
        return $this->value === $other->value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
