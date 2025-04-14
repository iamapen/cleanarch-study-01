<?php
declare(strict_types=1);

namespace Acme\Buckpal\Application\Domain\Model\Value;

use Acme\Buckpal\Application\Domain\Model\Entity\Activity;

/**
 * 取引ウィンドウ
 * 取引履歴を保持するクラス
 */
class ActivityWindow
{
    /** @var Activity[] */
    private array $activities = [];

    /**
     * @return Activity[]
     */
    public function getActivities(): array
    {
        return $this->activities;
    }

    public function addActivity(Activity $activity): void
    {
        $this->activities[] = $activity;
    }

    /**
     * 指定されたアカウントIDの残高を計算する
     * @param AccountId $accountId 残高計算の対象となるアカウントID
     * @return Money
     */
    public function calculateBalance(AccountId $accountId): Money
    {
        // 入金合計を計算（ターゲットアカウントが一致するアクティビティ）
        $depositBalance = Money::zero();
        foreach ($this->activities as $activity) {
            if ($activity->getTargetAccountId()->equals($accountId)) {
                $depositBalance = Money::add($depositBalance, $activity->getAmount());
            }
        }

        // 出金合計を計算（ソースアカウントが一致するアクティビティ）
        $withdrawalBalance = Money::zero();
        foreach ($this->activities as $activity) {
            if ($activity->getSourceAccountId()->equals($accountId)) {
                $withdrawalBalance = Money::add($withdrawalBalance, $activity->getAmount());
            }
        }

        // 残高 = 入金合計 - 出金合計
        return Money::add($depositBalance, $withdrawalBalance->negate());
    }
}
