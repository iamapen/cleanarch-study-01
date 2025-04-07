<?php
declare(strict_types=1);

namespace Acme\Buckpal\Adapter\Out\Persistence;

use Acme\Buckpal\Application\Domain\Model\Entity\Account;
use Acme\Buckpal\Application\Domain\Model\Value\AccountId;
use Acme\Buckpal\Application\Port\Out\LoadAccountPort;
use Acme\Buckpal\Application\Port\Out\UpdateAccountStatePort;
use DateTimeInterface;
use RuntimeException;

/**
 * 永続化アダプタ
 */
class AccountPersistenceAdapter implements LoadAccountPort, UpdateAccountStatePort
{
    private IAccountRepository $accountRepository;
    private IActivityRepository $activityRepository;
    private AccountMapper $accountMapper;

    public function __construct(
        IAccountRepository $accountRepository,
        IActivityRepository $activityRepository,
        AccountMapper $accountMapper
    )
    {
        $this->accountRepository = $accountRepository;
        $this->activityRepository = $activityRepository;
        $this->accountMapper = $accountMapper;
    }

    public function loadAccount(
        AccountId $accountId,
        DateTimeInterface $baselineDate
    ): Account {
        // 口座情報を取得
        $account = $this->accountRepository->findById($accountId);
        if ($account === null) {
            throw new RuntimeException('Account not found');
        }

        // 基準日以降に行われた全取引を取得
        $activities = $this->activityRepository->findByOwnerSince(
            $accountId,
            $baselineDate
        );

        // 基準日になるまでに発生したすべての引き出し合計金額を取得
        $withdrawalBalance = $this->activityRepository->getWithdrawalBalanceUntil(
            $accountId,
            $baselineDate
        );

        // 基準日になるまでに発生したすべての入金合計金額を取得
        $depositBalance = $this->activityRepository->getDepositBalanceUntil(
            $accountId,
            $baselineDate
        );

        // 口座情報をドメインモデルに変換
        return $this->accountMapper->mapToDomainEntity(
            $accountId,
            $activities,
            $withdrawalBalance,
            $depositBalance
        );
    }

    public function updateActivities(
        Account $account
    ): void {
        // 全取引を取得
        $activities = $account->getActivityWindow()->getActivities();
        foreach ($activities as $activity) {
            if ($activity->getId() == null) {
                // 新たに発生した取引であるため、保存
                $this->activityRepository->insert(
                    // 別に、ドメインモデルの Activity で扱えばよいように思う
                    // 本では、ドメインEntityから永続化Entityに面倒でも変換しろと書いてある
                    // 永続化視点ではn:1の関係、ドメイン観点では逆のほうが好ましい場合があり、その時は分けたほうがよさそうではあるが
                    $this->accountMapper->mapToEloquentEntity($activity)
                );
            }
        }
    }
}
