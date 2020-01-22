<?php
/**
 * Description of BaseCommand.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace Longman\TelegramBot\Commands\SystemCommands;


use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\Update;
use Longman\TelegramBot\Telegram;

class BaseCommand extends SystemCommand
{

    public function __construct(
        Telegram $telegram, Update $update = null
    )
    {
        parent::__construct($telegram, $update);
        $this->localize();
    }

    private function localize()
    {
        app()->setLocale($this->getMessage()->getFrom()->getLanguageCode());
    }

}
