<?php
declare(strict_types=1);

namespace Acme\Buckpal\Application\Domain\Model\Entity;

use Acme\Buckpal\Application\Domain\Model\Value\AccountId;
use Acme\Buckpal\Application\Domain\Model\Value\ActivityWindow;
use Acme\Buckpal\Application\Domain\Model\Value\Money;
use Acme\Buckpal\Application\Domain\Model\Entity\Activity;

/**
 * 口座 Domain Entity
 */
class Account
{
    private AccountId $id;
    /** @var Money 基準日が始まる時点の口座残高 */
    private Money $baselineBalance;
    /** @var ActivityWindow 取引の履歴 */
    private ActivityWindow $activityWindow;

    private function __construct(
        ?AccountId $id,
        Money $baselineBalance,
        ActivityWindow $activityWindow
    ) {
        $this->id = $id;
        $this->baselineBalance = $baselineBalance;
        $this->activityWindow = $activityWindow;
    }

    public static function withoutId(
        Money $baselineBalance,
        ActivityWindow $activityWindow
    ): static {
        return new static(null, $baselineBalance, $activityWindow);
    }

    public static function withId(
        AccountId $id,
        Money $baselineBalance,
        ActivityWindow $activityWindow
    ): static {
        return new static($id, $baselineBalance, $activityWindow);
    }


    public function getActivityWindow(): ActivityWindow
    {
        return $this->activityWindow;
    }

    /**
     * 残高を計算する
     * @return Money
     */
    public function calculateBalance(): Money
    {
        return Money::add(
            $this->baselineBalance,
            $this->activityWindow->calculateBalance($this->id)
        );
    }

    /**
     * 自身の口座から引き出す
     * ※自身の口座から送金先の口座に送金した、という取引を取引履歴に追加する
     * @param Money $money
     * @param AccountId $targetAccountId
     * @return bool
     */
    public function withdraw(Money $money, AccountId $targetAccountId): bool
    {
        if (!$this->mayWithdraw($money)) {
            return false;
        }

        // 取引履歴追加
        $withdrawal = new Activity(
            $this->id, $this->id, $targetAccountId, new \DateTimeImmutable(), $money
        );
        $this->activityWindow->addActivity($withdrawal);

        return true;
    }

    /**
     * 引き出し出せる金額か？
     * @param Money $money
     * @return bool
     */
    private function mayWithdraw(Money $money): bool
    {
        // 残高が不足している場合は、引き出し不可
        if (Money::subtract($this->calculateBalance(), $money)->getValue() < 0) {
            return false;
        }
        return true;
    }

    /**
     * 自身の口座に預け入れる
     * ※送金元の口座から自身の口座に送金された、という取引を取引履歴に追加する
     */
    public function deposit(Money $money, AccountId $sourceAccountId): bool
    {
        $deposit = new Activity(
            $this->id, $sourceAccountId, $this->id, new \DateTimeImmutable(), $money
        );
        $this->activityWindow->addActivity($deposit);
        return true;
    }
}
