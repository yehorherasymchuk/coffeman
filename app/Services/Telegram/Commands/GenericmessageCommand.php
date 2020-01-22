<?php
/**
 * Description of StartCommand.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace Longman\TelegramBot\Commands\SystemCommands;


use App\Services\Telegram\Handlers\Commands\GenericMessageCommandHandler;

class GenericmessageCommand extends BaseCommand
{
    protected $name = 'genericmessage';

    public function execute()
    {
        return app()->make(GenericMessageCommandHandler::class)->handle($this);
    }

}
