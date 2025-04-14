<?php
declare(strict_types=1);

namespace Acme\Buckpal\Adapter\In\Web;

use Acme\Buckpal\Application\Domain\Model\Value\AccountId;
use Acme\Buckpal\Application\Domain\Model\Value\Money;
use Acme\Buckpal\Application\Port\In\SendMoneyCommand;
use Acme\Buckpal\Application\Port\In\SendMoneyUseCase;

class SendMoneyController
{
    private SendMoneyUseCase $sendMoneyUseCase;

    public function sendMoney(
        AccountId $sourceAccountId,
        AccountId $targetAccountId,
        Money     $amount,
    ): void
    {
        $command = new SendMoneyCommand(
            $sourceAccountId,
            $targetAccountId,
            $amount
        );

        $this->sendMoneyUseCase->sendMoney($command);
    }
}
