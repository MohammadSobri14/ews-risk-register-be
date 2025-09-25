<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiskHandling;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\RiskHandlingSubmitted;
use App\Notifications\RiskHandlingReviewed;

class RiskHandlingController extends Controller
{
    public function store(Request $request)
    {
        $user = auth()->user();

        if (!in_array($user->role, ['quality_coordinator', 'unit_coordinator'])) {
            return response()->json([
                'message' => 'You do not have permission to perform this action.'
            ], 403);
        }

        $request->validate([
            'risk_id' => 'required|uuid|exists:risks,id',
            'effectiveness' => 'required|in:TE,KE,E',
            'barrier' => 'nullable|string|max:1000',
        ]);

        $handling = RiskHandling::create([
            'risk_id' => $request->risk_id,
            'handled_by' => $user->id,
            'effectiveness' => $request->effectiveness,
            'barrier' => $request->barrier,
        ]);

        return response()->json([
            'message' => 'Efektivitas penanganan berhasil disimpan.',
            'data' => $handling,
        ]);
    }

    public function getAll()
    {
        $user = auth()->user();

        // Normalize role checks to use the English role keys stored in the DB/seeders
        if (!in_array($user->role, ['quality_coordinator', 'unit_coordinator', 'health_center_head', 'risk_management_coordinator', 'admin'])) {
            return response()->json(['message' => 'You are not allowed to access this resource.'], 403);
        }

        $handlings = RiskHandling::with([
            'risk.causes.subCauses',
            'risk.mitigations.descriptions',
            'risk.mitigations.pic',
            'risk.riskAppetite',
            'risk.validations.validator',
            'risk.creator',
            'handler',
            'reviewer',
        ])
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'message' => 'Data penanganan risiko berhasil diambil.',
            'data' => $handlings,
        ]);
    }

    public function getAllPublic()
    {
        $handlings = RiskHandling::with([
            'risk.causes.subCauses',
            'risk.mitigations.descriptions',
            'risk.mitigations.pic',
            'risk.riskAppetite',
            'risk.validations.validator',
            'risk.creator',
            'handler',
            'reviewer',
        ])
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'message' => 'Data penanganan risiko berhasil diambil (tanpa validasi akses).',
            'data' => $handlings,
        ]);
    }

    public function sendToKepala($id)
    {
        $handling = RiskHandling::findOrFail($id);

        $handling->is_sent = true;
        $handling->save();

    // find health center head users (DB role key: health_center_head)
    $kepala = User::where('role', 'health_center_head')->get();

        Notification::send($kepala, new RiskHandlingSubmitted($handling));

        return response()->json([
            'message' => 'Notifikasi berhasil dikirim ke kepala puskesmas.',
        ]);
    }

    public function reviewHandling(Request $request, $id)
    {
        $user = auth()->user();

        // only health center head can review
        if ($user->role !== 'health_center_head') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'is_approved' => 'required|boolean',
            'notes' => 'nullable|string',
            'approval_signature' => 'nullable|string',
        ]);

        $handling = RiskHandling::findOrFail($id);
        $handling->is_approved = $request->is_approved;
        $handling->reviewed_by = $user->id;

        if ($request->is_approved) {
            if ($request->has('approval_signature')) {
                $handling->approval_signature = $request->approval_signature;
            }
            $handling->review_notes = null;
        } else {
            $handling->review_notes = $request->notes;
            $handling->approval_signature = null;
        }

        $handling->save();

        $creator = $handling->handledBy;
        Notification::send($creator, new RiskHandlingReviewed($handling));

        return response()->json([
            'message' => $request->is_approved
                ? 'Disetujui dan disahkan.'
                : 'Rejected and returned to coordinator.',
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();

        if (!in_array($user->role, ['quality_coordinator', 'unit_coordinator'])) {
            return response()->json([
                'message' => 'You do not have permission to perform this action.'
            ], 403);
        }

        $request->validate([
            'effectiveness' => 'required|in:TE,KE,E',
            'barrier' => 'nullable|string|max:1000',
        ]);

        $handling = RiskHandling::findOrFail($id);
        $handling->effectiveness = $request->effectiveness;
        $handling->barrier = $request->barrier;
        $handling->save();

        return response()->json([
            'message' => 'Efektivitas penanganan berhasil diperbarui.',
            'data' => $handling,
        ]);
    }

    public function destroy($id)
    {
        $user = auth()->user();

        if (!in_array($user->role, ['quality_coordinator', 'unit_coordinator'])) {
            return response()->json([
                'message' => 'You do not have permission to delete this resource.'
            ], 403);
        }

        $handling = RiskHandling::findOrFail($id);
        $handling->delete();

        return response()->json([
            'message' => 'Data penanganan risiko berhasil dihapus.'
        ]);
    }
}
