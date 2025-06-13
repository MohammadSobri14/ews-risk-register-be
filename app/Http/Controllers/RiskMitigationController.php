<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\RiskMitigation;   
use App\Models\MitigationDescription;

class RiskMitigationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'risk_id' => 'required|exists:risks,id',
            'mitigation_type' => 'required|in:regulasi,sdm,sarana_prasarana',
            'pic_id' => 'required|exists:users,id',
            'deadline' => 'required|date',
            'descriptions' => 'required|array|min:1',
            'descriptions.*' => 'required|string',
        ]);

        $mitigation = RiskMitigation::create([
            'risk_id' => $validated['risk_id'],
            'mitigation_type' => $validated['mitigation_type'],
            'pic_id' => $validated['pic_id'],
            'deadline' => $validated['deadline'],
            'created_by' => auth()->id(),
        ]);

        foreach ($validated['descriptions'] as $desc) {
            MitigationDescription::create([
                'mitigation_id' => $mitigation->id,
                'description' => $desc,
            ]);
        }

        return response()->json([
            'message' => 'Mitigasi risiko berhasil disimpan.',
            'data' => $mitigation->load('descriptions'),
        ], 201);
    }


    public function getMitigationsByRiskId($riskId)
    {
        $mitigations = RiskMitigation::with('descriptions', 'pic')
                        ->where('risk_id', $riskId)
                        ->get();

        return response()->json($mitigations);
    }


    public function show($id)
    {
        $mitigation = RiskMitigation::with('descriptions', 'pic')->findOrFail($id);
        return response()->json($mitigation);
    }

    public function index(Request $request)
    {
        $mitigations = RiskMitigation::with('descriptions', 'pic')->latest()->get();
        return response()->json($mitigations);
    }


    public function update(Request $request, $id)
    {
        $mitigation = RiskMitigation::with('descriptions')->findOrFail($id);

        $validated = $request->validate([
            'mitigation_type' => 'required|in:regulasi,sdm,sarana_prasarana',
            'pic_id' => 'required|exists:users,id',
            'deadline' => 'required|date',
            'descriptions' => 'required|array|min:1',
            'descriptions.*' => 'required|string',
        ]);

        $mitigation->update([
            'mitigation_type' => $validated['mitigation_type'],
            'pic_id' => $validated['pic_id'],
            'deadline' => $validated['deadline'],
        ]);

        $mitigation->descriptions()->delete();

        foreach ($validated['descriptions'] as $desc) {
            MitigationDescription::create([
                'mitigation_id' => $mitigation->id,
                'description' => $desc,
            ]);
        }

        return response()->json([
            'message' => 'Mitigasi risiko berhasil diperbarui.',
            'data' => $mitigation->load('descriptions'),
        ]);
    }

    public function destroy($id)
    {
        $mitigation = RiskMitigation::findOrFail($id);
        $mitigation->descriptions()->delete(); 
        $mitigation->delete(); 

        return response()->json(['message' => 'Mitigasi risiko berhasil dihapus.']);
    }

}