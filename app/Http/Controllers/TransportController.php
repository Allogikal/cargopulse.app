<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transport;

class TransportController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'number' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'loading_type' => 'required|string|max:255',
            'body_type' => 'required|string|max:255',
        ]);

        Transport::create($validated);
        return redirect()->back()->with('success', 'Транспорт успешно добавлен!');
    }

    public function destroy(Request $request, $id)
    {
        $transportItem = Transport::findOrFail($id);
        
        if ($request->user()->is_admin) {
            $transportItem->delete();
            return redirect()->back()->with('success', 'Компания успешно удалена');
        } else {
            return redirect()->back()->with('error', 'У вас нет прав на удаление компании');
        }
    }
}