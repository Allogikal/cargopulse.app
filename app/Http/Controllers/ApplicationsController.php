<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use Illuminate\Validation\Rule;

class ApplicationsController extends Controller
{
    public function update(Request $request, Application $application)
    {
        $validated = $request->validate([
            'status' => ['required', 'string', Rule::in(['Доставлено', 'В пути'])],
        ]);

        $application->update($validated);

        return response()->json(['success' => true]);
    }
}