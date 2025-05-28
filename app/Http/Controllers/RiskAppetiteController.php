<?php


namespace App\Http\Controllers;

use App\Models\RiskAppetite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RiskAppetiteController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'risk_id' => 'required|exists:risks,id',
            'controllability' => 'required|integer|min:1|max:4',
            'decision' => 'required|in:accepted,mitigated',
        ]);

        $appetite = RiskAppetite::create([
            'id' => Str::uuid(),
            'risk_id' => $validated['risk_id'],
            'controllability' => $validated['controllability'],
            'decision' => $validated['decision'],
            'created_by' => Auth::id(),
        ]);

        return response()->json([
            'message' => 'Risk appetite berhasil disimpan.',
            'data' => $appetite
        ]);
    }
}