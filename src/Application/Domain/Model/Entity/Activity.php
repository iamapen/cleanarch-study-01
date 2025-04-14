<?php
declare(strict_types=1);

namespace Acme\Buckpal\Application\Domain\Model\Entity;

use Acme\Buckpal\Application\Domain\Model\Value\AccountId;
use Acme\Buckpal\Application\Domain\Model\Value\ActivityId;
use Acme\Buckpal\Application\Domain\Model\Value\Money;

/**
 * 取引 Domain Entity
 */
class Activity
{
    private ActivityId $id;
    /** @var AccountId 口座所有者の口座ID */
    private AccountId $ownerAccountId;
    /** @var AccountId 送金元の口座ID */
    private AccountId $sourceAccountId;
    /** @var AccountId 送金先の口座ID */
    private AccountId $targetAccountId;
    private Money $amount;
    private \DateTimeInterface $timestamp;

    public function __construct(
        AccountId          $ownerAccountId,
        AccountId          $sourceAccountId,
        AccountId          $targetAccountId,
        \DateTimeInterface $timestamp,
        Money              $amount,
    )
    {
        $this->ownerAccountId = $ownerAccountId;
        $this->sourceAccountId = $sourceAccountId;
        $this->targetAccountId = $targetAccountId;
        $this->amount = $amount;
        $this->timestamp = $timestamp;
    }

    public function getId(): ActivityId
    {
        return $this->id;
    }

    public function getOwnerAccountId(): AccountId
    {
        return $this->ownerAccountId;
    }

    public function getSourceAccountId(): AccountId
    {
        return $this->sourceAccountId;
    }

    public function getTargetAccountId(): AccountId
    {
        return $this->targetAccountId;
    }

    public function getAmount(): Money
    {
        return $this->amount;
    }
    public function getTimestamp(): \DateTimeInterface
    {
        return $this->timestamp;
    }
}
