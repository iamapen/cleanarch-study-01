<?php
declare(strict_types=1);
namespace Acme\Chapter07\Buckpal\Adapter\Out\Persistence;

use Acme\Buckpal\Application\Domain\Model\Entity\Account;
use Acme\Buckpal\Application\Domain\Model\Value\AccountId;

/**
 * 口座リポジトリ
 */
interface IAccountRepository
{
    public function findById(AccountId $accountId): ?Account;
}
