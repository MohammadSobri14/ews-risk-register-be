<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiskHandling;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\RiskHandlingSubmitted;

class RiskHandlingController extends Controller
{
   public function store(Request $request)
   {
       $user = auth()->user();
   
       if (!in_array($user->role, ['koordinator_mutu', 'koordinator_unit'])) {
           return response()->json([
               'message' => 'Anda tidak memiliki izin untuk melakukan aksi ini.'
           ], 403);
       }
   
       $request->validate([
           'risk_id' => 'required|uuid|exists:risks,id',
           'effectiveness' => 'required|in:TE,KE,E',
       ]);
   
       $handling = RiskHandling::create([
           'risk_id' => $request->risk_id,
           'handled_by' => $user->id,
           'effectiveness' => $request->effectiveness,
       ]);
   
       return response()->json([
           'message' => 'Efektivitas penanganan berhasil disimpan.',
           'data' => $handling,
       ]);
   }
   

    // Kirim notifikasi ke kepala puskesmas berdasarkan ID RiskHandling
    public function sendToKepala($id)
    {
        $handling = RiskHandling::findOrFail($id);

        $kepala = User::where('role', 'kepala_puskesmas')->get();

        Notification::send($kepala, new RiskHandlingSubmitted($handling));

        return response()->json([
            'message' => 'Notifikasi berhasil dikirim ke kepala puskesmas.',
        ]);
    }
}
