<?php
declare(strict_types=1);
namespace Acme\Buckpal\Application\Port\Out;

use Acme\Buckpal\Application\Domain\Model\Entity\Account;

/**
 * 口座状態の更新
 */
interface UpdateAccountStatePort
{
    public function updateActivities(
        Account $account
    ): void;
}
