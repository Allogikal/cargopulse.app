<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Inertia\Response as InertiaResponse;

class AuthController extends Controller
{
    public function showLoginForm(): InertiaResponse
    {
        return inertia('Auth/SignInView');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($request->only('email', 'password'), $request->has('remember'))) {
            return Redirect::back();
        }

        $user = Auth::user();
        if (!$user->is_active) {
            Auth::logout();
            return Redirect::route('login')->withErrors(['email' => 'Ваш аккаунт заблокирован. Обратитесь к администратору.']);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        session(['sanctum_token' => $token]);

        return Redirect::route('profile')->with([
            'auth' => [
                'user' => Auth::user()->load('company'),
                ]
        ]);
    }

    public function showRegisterForm(): InertiaResponse
    {
        $companies = Company::all();
        return inertia('Auth/SignUpView', [
            'companies' => $companies,
        ]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string|max:20',
            'company_id' => 'required|exists:companies,id',
            'position' => 'required|string|max:255',
            'info' => 'nullable|string',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'privacy' => 'required|accepted',
        ]);

        $attributes = $validated;
        if ($request->hasFile('avatar')) {
            $attributes['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }
        $user = User::create($attributes);

        Auth::login($user);

        $token = $user->createToken('auth_token')->plainTextToken;
        session(['sanctum_token' => $token]);

        return Inertia::location(route('profile'), [
            'auth' => [
                'user' => Auth::user()->load('company'),
            ],
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()?->tokens()->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::route('login');
    }

    public function block(User $user)
    {
        if ($user->id === auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Нельзя заблокировать самого себя'], 403);
        }
        $user->update(['is_active' => false]);

        return response()->json(['success' => true]);
    }
}