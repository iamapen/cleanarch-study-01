<?php
declare(strict_types=1);

namespace Acme\Buckpal\Application\Domain\Model\Value;

/**
 * 取引ID Value Object
 */
class ActivityId
{
    private string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function of(string $value): static
    {
        return new static($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
