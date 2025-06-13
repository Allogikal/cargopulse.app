<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cargo;

class CargoController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'loading_country' => 'required|string|max:255',
            'loading_index' => 'required|string|max:255',
            'loading_city' => 'required|string|max:255',
            'loading_date' => 'required|date|max:255',
            'weight_tons' => 'required|numeric|min:0',
            'volume_m3' => 'nullable|numeric|min:0',
            'additional_weight' => 'nullable|numeric|min:0',
            'additional_info' => 'nullable|string',
            'unloading_country' => 'required|string|max:255',
            'unloading_index' => 'required|string|max:255',
            'unloading_country' => 'required|string|max:255',
            'unloading_city' => 'required|string|max:255',
            'unloading_date' => 'required|date|max:255',
            'price' => 'nullable|numeric|min:0',
            'currency' => 'required|in:Rub,USD,EUR',
            'vat_included' => 'boolean',
            'prepayment_required' => 'boolean',
        ]);
        Cargo::create($validated);

        return redirect()->back()->with('success', 'Груз успешно добавлен!');
    }
}