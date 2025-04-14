<?php
declare(strict_types=1);
namespace Acme\Buckpal\Application\Port\In;

use Acme\Buckpal\Application\Domain\Model\Value\AccountId;
use Acme\Buckpal\Application\Domain\Model\Value\Money;

/**
 * 送金 入力モデル
 */
class SendMoneyCommand {
    private AccountId $sourceAccountId;
    private AccountId $targetAccountId;
    private Money $amount;

    public function __construct(
        AccountId $sourceAccountId,
        AccountId $targetAccountId,
        Money $amount,
    )
    {
        $this->sourceAccountId = $sourceAccountId;
        $this->targetAccountId = $targetAccountId;

        if($amount->isNegative()) {
            throw new \InvalidArgumentException('送金額は0以上である必要があります');
        }
        $this->amount = $amount;
    }
}
