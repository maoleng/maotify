<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{

    public function index(): View
    {
        $categories = Category::query()->withCount('notifies')->get();

        return view('category.index', [
            'categories' => $categories,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Category::query()->create([
            'name' => $request->get('name'),
            'channel' => $request->get('channel'),
        ]);

        return back()->with('success', 'Create category successfully');
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $category->update([
            'name' => $request->get('name'),
            'channel' => $request->get('channel'),
        ]);

        return back()->with('success', 'Update category successfully');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->notifies()->exists()) {
            return back()->with('error', 'There are related notifies to this category');
        }
        $category->delete();

        return back()->with('success', 'Delete category successfully');
    }

}
