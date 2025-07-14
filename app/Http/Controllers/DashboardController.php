<?php

namespace App\Http\Controllers;

use App\Models\Pix;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $user = Auth::user();

        $pixStats = [
            'generated' => $user->pix()->where('status', Pix::STATUS_GENERATED)->count(),
            'paid' => $user->pix()->where('status', Pix::STATUS_PAID)->count(),
            'expired' => $user->pix()->where('status', Pix::STATUS_EXPIRED)->count(),
            'total' => $user->pix()->count(),
        ];

        $recentPix = $user->pix()
            ->latest()
            ->take(10)
            ->get();

        return Inertia::render('Dashboard', [
            'pixStats' => $pixStats,
            'recentPix' => $recentPix,
        ]);
    }
}
