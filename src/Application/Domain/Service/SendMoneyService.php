<?php
declare(strict_types=1);

namespace Acme\Buckpal\Application\Domain\Service;

use Acme\Buckpal\Application\Port\In\SendMoneyCommand;
use Acme\Buckpal\Application\Port\In\SendMoneyUseCase;
use Acme\Buckpal\Application\Port\Out\LoadAccountPort;
use Acme\Buckpal\Application\Port\Out\UpdateAccountStatePort;

/**
 * 送金サービス
 */
class SendMoneyService implements SendMoneyUseCase
{
    private LoadAccountPort $loadAccountPort;
    private UpdateAccountStatePort $updateAccountStatePort;

    public function sendMoney(SendMoneyCommand $command): bool
    {
        // TODO ビジネスルールに関する妥当性確認を行う
        // 送金元の口座が存在するか？
        // 送金先の口座が存在するか？

        // TODO モデルの状態を変える
        // TODO 処理結果を返す
        return true;
    }
}
