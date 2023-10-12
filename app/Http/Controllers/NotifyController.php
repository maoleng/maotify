<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Notify;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotifyController extends Controller
{

    public function index(Request $request): View
    {
        $q = Notify::query();
        if ($request->get('category_id') !== null) {
            $q->where('category_id', $request->get('category_id'));
        }
        $notifies = $q->get();

        return view('notify.index', [
            'notifies' => $notifies,
            'categories' => Category::query()->get(),
        ]);
    }

    public function show(Notify $notify): View
    {
        return view('notify.show', [
            'notify' => $notify->load('contents'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->all();
        $banner = $request->file()['banner'] ?? null;

        Notify::query()->create([
            'name' => $data['name'],
            'banner' => uploadToDiscord($banner->getContent(), $banner->extension()),
            'type' => $data['type'],
            'schedule' => $data['schedule'],
            'category_id' => $data['category_id'],
        ]);

        return back()->with('success', 'Create content successfully');
    }

    public function update(Request $request, Notify $notify): RedirectResponse
    {
        $data = $request->all();
        $banner = $request->file()['banner'] ?? null;

        $update_data = [
            'name' => $data['name'],
            'type' => $data['type'],
            'schedule' => $data['schedule'],
            'category_id' => $data['category_id'],
        ];
        if ($banner !== null) {
            $update_data['banner'] = uploadToDiscord($banner->getContent(), $banner->extension());
        }

        $notify->update($update_data);

        return back()->with('success', 'Create content successfully');
    }

    public function destroy(Notify $notify): RedirectResponse
    {
        if ($notify->contents()->exists()) {
            return back()->with('error', 'There are related contents to this notify');
        }
        $notify->delete();

        return back()->with('success', 'Delete notify successfully');
    }

}
