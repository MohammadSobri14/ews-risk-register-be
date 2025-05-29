<?php


namespace App\Http\Controllers;

use App\Models\Risk;
use App\Models\RiskAnalysis;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use App\Notifications\RiskAnalysisSent;

class RiskAnalysisController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'risk_id' => 'required|uuid|exists:risks,id',
            'severity' => 'required|integer|min:1|max:5',
            'probability' => 'required|integer|min:1|max:5',
        ]);
    
        // Hitung score
        $score = $validated['severity'] * $validated['probability'];
    
        $analysis = RiskAnalysis::create([
            ...$validated,
            'score' => $score,
            'created_by' => auth()->id(),
        ]);
    
        return response()->json($analysis, 201);
    }
    

    public function sendToManris($id)
    {
        $analysis = RiskAnalysis::findOrFail($id);
        $analysis->save();

        $risk = $analysis->risk; 
        $risk->status = 'pending';
        $risk->save();

        // Kirim notifikasi
        $manrisUsers = User::where('role', 'koordinator_menris')->get();
        Notification::send($manrisUsers, new RiskAnalysisSent($analysis));

        return response()->json(['message' => 'Dikirim ke Koordinator Manajemen Risiko']);
    }


}