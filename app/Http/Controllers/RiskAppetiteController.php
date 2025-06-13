<?php

namespace App\Http\Controllers;

use App\Models\RiskAppetite;
use App\Models\Risk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RiskAnalysis;
use Illuminate\Support\Str;

class RiskAppetiteController extends Controller
{
    public function store(Request $request)
{
    $validated = $request->validate([
        'risk_id' => 'required|exists:risks,id',
        'controllability' => 'required|integer|min:1|max:4',
        'decision' => 'nullable|in:accepted,mitigated',
    ]);

    // Ambil data risk analysis terbaru dari risk_id
    $analysis = RiskAnalysis::where('risk_id', $validated['risk_id'])
        ->latest()
        ->first();

    if (!$analysis) {
        return response()->json([
            'message' => 'Risk analysis tidak ditemukan untuk risk ini.'
        ], 404);
    }

    $severity = $analysis->severity;
    $probability = $analysis->probability;
    $controllability = $validated['controllability'];

    $scoring = $severity * $probability * $controllability;

    $appetite = RiskAppetite::create([
        'id' => Str::uuid(),
        'risk_id' => $validated['risk_id'],
        'controllability' => $controllability,
        'decision' => $validated['decision'] ?? null,
        'scoring' => $scoring,
        'created_by' => Auth::id(),
    ]);

    $this->recalculateRanking();

    return response()->json([
        'message' => 'Risk appetite berhasil disimpan.',
        'data' => $appetite->fresh()
    ]);
}

    protected function recalculateRanking()
    {
        // Ambil semua dan urutkan berdasarkan scoring (tinggi ke rendah)
        $all = RiskAppetite::orderByDesc('scoring')->get();

        $rank = 1;
        foreach ($all as $item) {
            $item->ranking = $rank++;
            $item->save();
        }
    }

    public function updateDecision(Request $request, $id)
    {
        $validated = $request->validate([
            'decision' => 'required|in:accepted,mitigated',
        ]);

        $appetite = RiskAppetite::findOrFail($id);

        // Cek apakah decision sudah pernah diisi
        if (!is_null($appetite->decision)) {
            return response()->json([
                'message' => 'Decision sudah ditetapkan dan tidak dapat diubah lagi.'
            ], 400);
        }

        $appetite->decision = $validated['decision'];
        $appetite->save();

        return response()->json([
            'message' => 'Decision berhasil ditetapkan.',
            'data' => $appetite->fresh(),
        ]);
    }


    public function updateControllability(Request $request, $id)
{
    $validated = $request->validate([
        'controllability' => 'required|integer|min:1|max:4',
    ]);

    $appetite = RiskAppetite::findOrFail($id);

    // Ambil data analisis terkait
    $analysis = RiskAnalysis::where('risk_id', $appetite->risk_id)
        ->latest()
        ->first();

    if (!$analysis) {
        return response()->json([
            'message' => 'Risk analysis tidak ditemukan untuk risk ini.'
        ], 404);
    }

    $severity = $analysis->severity;
    $probability = $analysis->probability;
    $controllability = $validated['controllability'];

    $appetite->controllability = $controllability;
    $appetite->scoring = $severity * $probability * $controllability;
    $appetite->save();

    $this->recalculateRanking();

    return response()->json([
        'message' => 'Controllability berhasil diperbarui.',
        'data' => $appetite->fresh()
    ]);
}


}