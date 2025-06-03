<?php


namespace App\Http\Controllers;

use App\Models\Risk;
use App\Models\RiskAnalysis;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use App\Notifications\RiskAnalysisSent;
use Illuminate\Support\Facades\Auth;

class RiskAnalysisController extends Controller
{
    public function getAll()
    {
        $user = Auth::user();

        if ($user->role === 'koordinator_unit') {
            // Hanya ambil data yang dibuat oleh user login
            $analyses = RiskAnalysis::with(['risk', 'creator'])
                ->where('created_by', $user->id)
                ->get();
        } else {
            // Role lain, kosongkan hasil
            $analyses = collect(); // atau ->whereRaw('1 = 0')->get()
            $analyses = collect();
        }

        return response()->json($analyses);
    }

    public function getById($id)
    {
        $analysis = RiskAnalysis::with(['risk', 'creator'])->findOrFail($id);

        $user = Auth::user();
        // Validasi agar user hanya bisa akses data yang dia buat
        if ($user->role === 'koordinator_unit' && $analysis->created_by !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($analysis);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'risk_id' => 'required|uuid|exists:risks,id',
            'severity' => 'required|integer|min:1|max:5',
            'probability' => 'required|integer|min:1|max:5',
        ]);

        $score = $validated['severity'] * $validated['probability'];
        $grading = RiskAnalysis::calculateGrading($score);

        $analysis = RiskAnalysis::create([
            ...$validated,
            'score' => $score,
            'grading' => $grading,
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

    public function update(Request $request, $id)
    {
        $analysis = RiskAnalysis::findOrFail($id);
        $user = Auth::user();
        if ($user->role !== 'koordinator_unit' || $analysis->created_by !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'severity' => 'required|integer|min:1|max:5',
            'probability' => 'required|integer|min:1|max:5',
        ]);

        $score = $validated['severity'] * $validated['probability'];
        $grading = RiskAnalysis::calculateGrading($score);

        $analysis->update([
            'severity' => $validated['severity'],
            'probability' => $validated['probability'],
            'score' => $score,
            'grading' => $grading,
        ]);

        return response()->json($analysis);
    }

    public function delete($id)
    {
        $analysis = RiskAnalysis::findOrFail($id);

        $user = Auth::user();
        if ($user->role !== 'koordinator_unit' || $analysis->created_by !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $analysis->delete();

        return response()->json(['message' => 'Risk analysis deleted successfully']);
    }


    public function getPendingAndApproved()
    {
        $user = Auth::user();

        if ($user->role !== 'koordinator_menris') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $risks = Risk::with('analysis')
            ->whereIn('status', ['pending', 'validated_approved'])
            ->whereHas('analysis')
            ->get();

        return response()->json($risks);
    }



}
