<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ApplicationsController extends Controller
{
    public function storeFromCargo(Request $request)
    {
        $cargoId = $request->input('cargo_id');
        $cargo = Cargo::findOrFail($cargoId);
        $application = Application::create([
            'loading_country' => $cargo->loading_country,
            'loading_index' => $cargo->loading_index,
            'loading_city' => $cargo->loading_city,
            'loading_date' => $cargo->loading_date,
            'weight_tons' => $cargo->weight_tons,
            'volume_m3' => $cargo->volume_m3,
            'can_co_load' => $cargo->can_co_load,
            'additional_info' => $cargo->additional_info,
            'unloading_country' => $cargo->unloading_country,
            'unloading_index' => $cargo->unloading_index,
            'unloading_city' => $cargo->unloading_city,
            'unloading_date' => $cargo->unloading_date,
            'price' => $cargo->price,
            'nds' => $cargo->nds,
            'prepayment' => $cargo->prepayment,
            'loading_type' => $cargo->loading_type,
            'body_type' => $cargo->body_type,
            'status' => 'В пути',
            'company_id' => $cargo->company_id,
        ]);
        $cargo->delete();

        return redirect()->back()->with('success', 'Груз успешно принят и добавлен в заявки.');
    }

    public function update(Request $request, Application $application)
    {
        $validated = $request->validate([
            'status' => ['required', 'string', Rule::in(['Доставлено', 'В пути'])],
        ]);

        $application->update($validated);

        return response()->json(['success' => true]);
    }
}