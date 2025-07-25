<?php

namespace App\Http\Controllers;

use App\Models\Pix;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class PixController extends Controller
{
    public function store(): Response
    {
        $pix = Pix::create([
            'user_id' => Auth::id(),
        ]);

/*         return response()->json([
            'token' => $pix->token,
            'expires_at' => $pix->expires_at,
            'qr_code_url' => route('pix.confirm', $pix->token),
        ]);  */
        
/* 
        return Redirect::back()->with([
            'token' => $pix->token,
            'expires_at' => $pix->expires_at,
            'qr_code_url' => route('pix.confirm', $pix->token)
        ]); */

         return Inertia::render('', [
            'token' => $pix->token,
            'expires_at' => $pix->expires_at
        ]); 
    }

    public function confirm(string $token): Response
    {
        $pix = Pix::where('token', $token)->firstOrFail();

        if ($pix->isExpired() && $pix->status === Pix::STATUS_GENERATED) {
            $pix->markAsExpired();
        } elseif ($pix->status === Pix::STATUS_GENERATED) {
            $pix->markAsPaid();
        }

        return Inertia::render('Pix/Confirm', [
            'pix' => $pix->fresh(),
        ]);
    }

    public function checkStatusPixMonitoring(string $token): Response
    {
        $pix = Pix::where('token', $token)->firstOrFail();
        
        if ($pix->isExpired() && $pix->status === Pix::STATUS_GENERATED) {
            $pix->markAsExpired();
        } elseif ($pix->status === Pix::STATUS_PAID) {
            return Inertia::render('Pix/Success', [

            ]);
        }
    }
}
