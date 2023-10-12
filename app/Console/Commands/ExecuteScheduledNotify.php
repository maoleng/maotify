<?php

namespace App\Console\Commands;

use App\Enums\NotifyType;
use App\Models\Notify;
use Carbon\Carbon;
use Cron\CronExpression;
use Illuminate\Console\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class ExecuteScheduledNotify extends Command
{

    protected $signature = 'notify:fire';

    public function handle(): void
    {
        $notifies = Notify::query()->get();
        foreach ($notifies as $notify) {
            $chat_id = $notify->category->channel;
            if ($this->isScheduledToRun($notify->schedule)) {
                $content = $this->getNextContent($notify);
                $notify->type === NotifyType::PHOTO ?
                    Telegram::sendPhoto(['chat_id' => $chat_id, 'photo' => $content->value['photo']]) :
                    Telegram::sendMessage(['chat_id' => $chat_id, 'text' => $content->value['text']]);
            }
        }
    }

    private function getNextContent($notify)
    {
        $contents = $notify->contents;
        if ($notify->content_id === null || $notify->content_id >= $contents->last()->id) {
            $next_id = $contents->first()->id;
        } else {
            $next_id = $contents->where('id', '>', $notify->content_id)->first()->id ?? $contents->first()->id;
        }
        $notify->update(['content_id' => $next_id]);

        return $contents->find($next_id);
    }

    private function isScheduledToRun($cron_expression): bool
    {
        $cron = new CronExpression($cron_expression);
        $now = Carbon::now();

        return $cron->isDue($now);
    }

}
