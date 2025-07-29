<?php

namespace App\Http\Controllers;

use App\Models\Pix;
use App\Models\User;
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

        $statsFiltered = $this->browseStatsPix();
        $usersCount = $this->browseStatsDashboard();

        return Inertia::render('Dashboard', [
            'pixStats' => $pixStats,
            'recentPix' => $recentPix,
            'statsFiltered' => $statsFiltered,
            'usersCount' => $usersCount
        ]);
    }

    public function browseStatsPix()
    {
        $inicio = microtime(true);
        $user = Auth::user();

        $stats = $user->pix()
            ->selectRaw('
                COUNT(*) as total,
                SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as paid,
                SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as expired,
                SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as generated
            ', [Pix::STATUS_PAID, Pix::STATUS_EXPIRED, Pix::STATUS_GENERATED])
            ->first();
        $fim = microtime(true);
        $tempoDeExecucao = $fim - $inicio;

        $statsFiltered = [
            'total' => (int) $stats->total,
            'paid' => (int) $stats->paid,
            'expired' => (int) $stats->expired,
            'generated' => (int) $stats->generated,
            'tempoDeExecucao' =>(float) $tempoDeExecucao
        ];

        return $statsFiltered;
    }

    public function browseStatsDashboard()
    {
        $users = User::all();

        $usersCount = $users->count();

        return $usersCount;
    }

}
