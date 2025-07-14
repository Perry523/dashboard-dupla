<?php

namespace App\Http\Controllers;

use App\Models\Pix;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class PixController extends Controller
{
    public function store(): JsonResponse
    {
        $pix = Pix::create([
            'user_id' => Auth::id(),
        ]);

        return response()->json([
            'token' => $pix->token,
            'expires_at' => $pix->expires_at,
            'qr_code_url' => route('pix.confirm', $pix->token),
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
}
