<?php
declare(strict_types=1);
namespace Acme\Buckpal\Application\Port\Out;

use Acme\Buckpal\Application\Domain\Model\Entity\Account;
use Acme\Buckpal\Application\Domain\Model\Value\AccountId;

/**
 * 口座情報を取得するためのポート
 */
interface LoadAccountPort
{
    /**
     * 口座情報を取得
     * @param AccountId $accountId
     * @param \DateTimeInterface $baselineDate 基準日
     * @return Account
     */
    public function loadAccount(
        AccountId $accountId,
        \DateTimeInterface $baselineDate
    ): Account;
}
