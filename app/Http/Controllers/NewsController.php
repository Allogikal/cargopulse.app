<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);
        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }
        News::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'avatar' => $avatarPath,
        ]);

        return redirect()->back()->with('success', 'Новость успешно добавлена!');
    }
    
    public function destroy(Request $request, $id)
    {
        $newsItem = News::findOrFail($id);
        
        if ($request->user()->is_admin) {
            $newsItem->delete();
            return redirect()->back()->with('success', 'Компания успешно удалена');
        } else {
            return redirect()->back()->with('error', 'У вас нет прав на удаление компании');
        }
    }
}