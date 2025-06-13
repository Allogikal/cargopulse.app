<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function block($id)
    {
        $user = User::findOrFail($id);
        if ($user->id === auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Самопроизвольная ошибка'], 403);
        }
        $user->update(['is_active' => false]);

        return response()->json(['success' => true]);
    }
}