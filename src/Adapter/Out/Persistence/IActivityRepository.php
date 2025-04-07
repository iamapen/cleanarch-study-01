<?php
declare(strict_types=1);
namespace Acme\Chapter07\Buckpal\Adapter\Out\Persistence;

use Acme\Buckpal\Application\Domain\Model\Entity\Activity;
use Acme\Buckpal\Application\Domain\Model\Value\AccountId;
use DateTimeInterface;

/**
 * 取引リポジトリ
 */
interface IActivityRepository
{
    /**
     * @param AccountId $ownerAccountId
     * @param DateTimeInterface $since 基準日
     * @return Activity[]
     */
    public function findByOwnerSince(
        AccountId $ownerAccountId,
        DateTimeInterface $since
    ): array;

    /**
     * 基準日になるまでに発生したすべての入金の合計金額を取得
     * @param AccountId $accountId
     * @param DateTimeInterface $until
     * @return int
     */
    public function getDepositBalanceUntil(
        AccountId $accountId,
        DateTimeInterface $until
    ): int;

    /**
     * 基準日になるまでに発生したすべての引き出しの合計金額を取得
     * @param AccountId $accountId
     * @param DateTimeInterface $until
     * @return int
     */
    public function getWithdrawalBalanceUntil(
        AccountId $accountId,
        DateTimeInterface $until
    ): int;

    public function insert(Activity $activity): void;
}
