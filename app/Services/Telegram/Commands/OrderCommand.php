<?php
/**
 * Description of OrderCommand.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace Longman\TelegramBot\Commands\SystemCommands;


use App\Services\Dots\DotsService;
use App\Services\Telegram\Handlers\Commands\OrderCommandHandler;

class OrderCommand extends BaseCommand
{
    protected $name = 'order';
    protected $usage = '/order';

    public function execute()
    {
        return app(OrderCommandHandler::class)->handle($this);
    }

}
