<?php
declare(strict_types=1);

namespace Acme\Buckpal\Adapter\Out\Persistence;

use Acme\Buckpal\Application\Domain\Model\Entity\Account;
use Acme\Buckpal\Application\Domain\Model\Entity\Activity;
use Acme\Buckpal\Application\Domain\Model\Value\AccountId;
use Acme\Buckpal\Application\Domain\Model\Value\ActivityWindow;
use Acme\Buckpal\Application\Domain\Model\Value\Money;

/**
 * Account のレイヤ間変換
 */
class AccountMapper
{

    public function mapToDomainEntity(
        AccountId $accountId,
        array $activities,
        int $withdrawalBalance,
        int $depositBalance
    ): Account {
        $baselineBalance = Money::subtract(
            Money::of($depositBalance), Money::of($withdrawalBalance)
        );
        $activityWindow = $this->mapToActivityWindow($activities);
        // 口座情報をドメインモデルに変換
        return Account::withId($accountId, $baselineBalance, $activityWindow, $withdrawalBalance, $depositBalance);
    }

    /**
     * @param Activity[] $activities
     * @return ActivityWindow
     */
    private function mapToActivityWindow(array $activities): ActivityWindow
    {
        $mappedActivities = [];
        foreach ($activities as $activity) {
            $mappedActivities[] = new Activity(
                $activity->getId(),
                $activity->getOwnerAccountId(),
                $activity->getSourceAccountId(),
                $activity->getTargetAccountId(),
                $activity->getAmount(),
                $activity->getTimestamp()
            );
        }
        return new ActivityWindow($mappedActivities);
    }

    public function mapToEloquentEntity(Activity $activity)
    {
        // 省略: eloquent modelを返すよう実装
    }
}
