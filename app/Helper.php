<?php

use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Telegram\Bot\Laravel\Facades\Telegram;

if (! function_exists('notifyAlert')) {
    function notifyAlert(): string
    {
        $success = session()->get('success');
        if ($success !== null) {
            return "
                 Swal.fire({
                    icon: 'success',
                    title: '$success',
                })
            ";
        }
        $error = session()->get('error');
        if ($error !== null) {
            return "
                 Swal.fire({
                    icon: 'error',
                    title: '$error',
                })
            ";
        }

        return '';
    }
}

if (! function_exists('uploadToDiscord')) {
    function uploadToDiscord($content, $extension): string
    {
        $client = new Client(['headers' => [
            'authorization' => 'Bot '.env('DISCORD_TOKEN'),
            'Content-Type' => 'multipart/form-data',
        ]]);
        $channel_id = env('DISCORD_CHANNEL_ID');

        $response = $client->post("https://discord.com/api/v9/channels/$channel_id/messages", [
            'multipart' => [
                [
                    'name' => 'a',
                    'contents' => $content,
                    'filename' => Str::random().".$extension",
                ],
            ],
        ])->getBody()->getContents();

        return json_decode($response, true)['attachments'][0]['url'];
    }
}


if (! function_exists('getFileFromTelegram')) {
    function getFileFromTelegram($file_id): string
    {
        $path = Telegram::getFile(['file_id' => $file_id])->toArray()['file_path'];

        return 'https://api.telegram.org/file/bot'.env('TELEGRAM_BOT_TOKEN').'/'.$path;
    }
}

