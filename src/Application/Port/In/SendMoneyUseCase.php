<?php
declare(strict_types=1);

namespace Acme\Buckpal\Application\Port\In;

interface SendMoneyUseCase
{
    public function sendMoney(SendMoneyCommand $command,): bool;
}
