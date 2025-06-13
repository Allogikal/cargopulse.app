<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Inertia\Response as InertiaResponse;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'required|string|max:20',
            'info' => 'nullable|string',
        ]);
        $user = Auth::user();
        $user->update($validated);

        return back()->with('success', 'Профиль успешно обновлён');
    }

    public function addEmployee(Request $request)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'user_id' => 'required|exists:users,id|unique:users,company_id,NULL,id,company_id,' . $request->company_id,
        ]);

        $user = User::findOrFail($validated['user_id']);
        $user->update(['company_id' => $validated['company_id']]);

        return response()->json(['success' => true]);
    }
}
