<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'inn' => 'required|unique:companies',
            'country' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'registration_address' => 'required|string|max:255',
            'postal_address' => 'required|string|max:255',
            'rate' => 'required|integer|max:255',
            'email' => 'required|string|max:255',
            'activity' => 'required|string|max:255',
            'cargos_statistics_month' => 'required|integer|max:255',
            'cargos_statistics_year' => 'required|integer|max:255',
            'cargos_statistics_all_time' => 'required|integer|max:255',
            'registered_at' => 'required|string|max:255',
            'last_login' => 'required|string|max:255',
        ]);
        Company::create($validated);

        return redirect()->back()->with('success', 'Компания успешно добавлена!');
    }

    public function destroy(Request $request, $id)
    {
        $company = Company::findOrFail($id);
        
        if ($request->user()->is_admin) {
            $company->delete();
            return redirect()->back()->with('success', 'Компания успешно удалена');
        } else {
            return redirect()->back()->with('error', 'У вас нет прав на удаление компании');
        }
    }
}