<?php
declare(strict_types=1);

namespace Acme\Buckpal\Adapter\In\Web;

use Acme\Buckpal\Application\Domain\Model\Value\AccountId;
use Acme\Buckpal\Application\Domain\Model\Value\Money;
use Acme\Buckpal\Application\Port\In\SendMoneyUseCase;

/**
 * 口座に関するリクエストをすべて単一のコントローラで受けようとする悪い例
 */
class AccountController
{
    private GetAccountBalanceQuery $getAccountBalanceQuery;
    private ListAccountsQuery $listAccountsQuery;
    private LoadAccountQuery $loadAccountQuery;

    private SendMoneyUseCase $sendMoneyUseCase;
    private CreateAccountUseCase $createAccountUseCase;

    public function listAccounts(): void
    {
    }

    public function getAccount(AccountId $accountId): void
    {
    }

    public function getAccountBalance(AccountId $accountId): void
    {
    }

    public function createAccount(): void
    {
    }

    public function sendMoney(
        AccountId $sourceAccountId,
        AccountId $targetAccountId,
        Money     $amount,
    ): void
    {
    }
}
