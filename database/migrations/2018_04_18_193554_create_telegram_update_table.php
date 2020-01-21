<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTelegramUpdateTable extends Migration
{
    public function up()
    {
        Schema::create('telegram_update', static function (Blueprint $table) {
            $table->bigInteger('id')->unsigned()->primary()->comment('Update\'s unique identifier');
            $table->bigInteger('chat_id')->nullable()->comment('Unique chat identifier');
            $table->bigInteger('message_id')->unsigned()->nullable()->comment('Unique message identifier');
            $table->bigInteger('inline_query_id')->unsigned()->nullable()->index('inline_query_id')->comment('Unique inline query identifier');
            $table->bigInteger('chosen_inline_result_id')->unsigned()->nullable()->index('chosen_inline_result_id')->comment('Local chosen inline result identifier');
            $table->bigInteger('callback_query_id')->unsigned()->nullable()->index('callback_query_id')->comment('Unique callback query identifier');
            $table->bigInteger('edited_message_id')->unsigned()->nullable()->index('edited_message_id')->comment('Local edited message identifier');
            $table->bigInteger('channel_post_id')->unsigned()->nullable()->index('channel_post_id');
            $table->bigInteger('edited_channel_post_id')->unsigned()->nullable()->index('edited_channel_post_id');
            $table->bigInteger('shipping_query_id')->unsigned()->nullable()->index('shipping_query_id');
            $table->bigInteger('pre_checkout_query_id')->unsigned()->nullable()->index('pre_checkout_query_id');
            $table->bigInteger('poll_id')->unsigned()->nullable()->index('poll_id');
            $table->index(['chat_id', 'message_id'], 'message_id');
        });
    }

    public function down()
    {
        Schema::drop('telegram_update');
    }
}
