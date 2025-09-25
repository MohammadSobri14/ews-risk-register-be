<?php

namespace App\Http\Controllers;

use App\Models\Risk;
use App\Models\RiskValidation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\RiskValidationNotification;

class RiskValidationController extends Controller
{
    public function validateRisk(Request $request, $riskId)
    {
        $request->validate([
            'is_approved' => 'required|boolean',
            'notes' => 'nullable|string',
        ]);

        $risk = Risk::findOrFail($riskId);

        $validation = RiskValidation::create([
            'risk_id' => $risk->id,
            'validated_by' => optional($request->user())->id,
            'is_approved' => $request->is_approved,
            'notes' => $request->notes,
        ]);

        if ($validation->is_approved) {
            $risk->status = 'validated_approved';
            $risk->save();

            $qualityUsers = User::where('role', 'quality_coordinator')->get();
            Notification::send($qualityUsers, new RiskValidationNotification($risk, true));

            $unitUsers = User::where('role', 'unit_coordinator')->get();
            Notification::send($unitUsers, new RiskValidationNotification($risk, true));
        } else {
            $risk->status = 'validated_rejected';
            $risk->save();

            $unitUsers = User::where('role', 'unit_coordinator')->get();
            Notification::send($unitUsers, new RiskValidationNotification($risk, false, $validation->notes));
        }

        return response()->json(['message' => 'Validation saved successfully.']);
    }


    public function getValidatedRisks()
    {
        $validatedRisks = Risk::with([
            'causes.subCauses',
            'analysis',
            'riskAppetite'
        ])
        ->whereIn('status', ['validated_approved', 'validated_rejected'])
        ->get();

        return response()->json($validatedRisks);
    }


}
