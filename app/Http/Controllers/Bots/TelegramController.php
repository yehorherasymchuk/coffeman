<?php
/**
 * Description of TelegramController.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Http\Controllers\Bots;


use App\Http\Controllers\Controller;
use PhpTelegramBot\Laravel\PhpTelegramBotContract;

class TelegramController extends Controller
{

    /** @var PhpTelegramBotContract */
    private $telegramBot;

    public function __construct(
        PhpTelegramBotContract $telegramBot
    )
    {
        $this->telegramBot = $telegramBot;
    }

    public function updates()
    {
        return $this->telegramBot->handleGetUpdates();
    }

}
