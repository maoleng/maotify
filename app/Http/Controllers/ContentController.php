<?php

namespace App\Http\Controllers;

use App\Enums\NotifyType;
use App\Models\Content;
use App\Models\Notify;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Laravel\Facades\Telegram;

class ContentController extends Controller
{

    public function store(Request $request): RedirectResponse
    {
        $notify = Notify::query()->find($request->get('notify_id'));

        $notify->type === NotifyType::TEXT ?
            $this->storeText($request->get('contents'), $notify->id) :
            $this->storeImage($request->allFiles()['contents'], $notify);
        $notify->increment('count');

        return back()->with('success', 'Create content successfully');
    }

    private function storeImage($files, $notify): void
    {
        $data = [];
        $chat_id = $notify->category->channel;
        foreach ($files as $file) {
            $response = Telegram::sendPhoto([
                'chat_id' => $chat_id,
                'photo' => InputFile::createFromContents($file->getContent(), $file->hashName()),
            ]);
            $photos = $response->toArray()['photo'];

            $data[] = [
                'notify_id' => $notify->id,
                'value' => json_encode([
                    'photo' => reset($photos)['file_id'],
                    'banner' => uploadToDiscord(file_get_contents(getFileFromTelegram(reset($photos)['file_id'])), $file->extension()),
                ]),
            ];
        }

        Content::query()->insert($data);
    }

    private function storeText($contents, $notify_id): void
    {
        $data = [];
        $contents = explode("\r\n", $contents);
        foreach ($contents as $content) {
            $data[] = [
                'notify_id' => $notify_id,
                'value' => json_encode([
                    'text' => $content,
                ]),
            ];
        }

        Content::query()->insert($data);
    }

    public function destroy(Content $content): void
    {
        $content->delete();
    }

}
