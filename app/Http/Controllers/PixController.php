<?php

namespace App\Http\Controllers;

use App\Models\Pix;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PixController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Auth::user()->pix()->latest();

        if ($request->has('search') && $request->search) {
            $query->where('token', 'like', '%' . $request->search . '%');
        }

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $perPage = $request->get('per_page', 20);
        if ($perPage === 'all') {
            $pixList = $query->get();
            $total = $pixList->count();
            $currentPage = 1;
            $lastPage = 1;
        } else {
            $paginated = $query->paginate((int)$perPage);
            $pixList = $paginated->items();
            $total = $paginated->total();
            $currentPage = $paginated->currentPage();
            $lastPage = $paginated->lastPage();
        }

        return response()->json([
            'data' => $pixList,
            'meta' => [
                'total' => $total,
                'current_page' => $currentPage,
                'last_page' => $lastPage,
                'per_page' => $perPage,
            ],
            'filters' => [
                'search' => $request->search,
                'status' => $request->status ?: 'all',
            ],
        ]);
    }

    public function store(Request $request): Response
    {
        $request->validate([
            'expires_in_minutes' => 'nullable|integer|min:1|max:1440',
        ]);

        $expiresInMinutes = $request->input('expires_in_minutes', 10);

        $recordList = $this->storeList(
            $request->usersDestination,
            Auth::id(),
            $expiresInMinutes
        );
        
        return Inertia::render('GeneratePixCharge', [$recordList]);
    }

    public function confirm(string $token): Response
    {
        $pix = Pix::where('token', $token)->with('user')->firstOrFail();

        if ($pix->status === Pix::STATUS_GENERATED) {
            $pix->markAsPaid();
        }

        return Inertia::render('Pix/Confirm', [
            'pix' => $pix->fresh(['user']),
        ]);
    }
    
    public function qrcode(string $token)
    {
        $pix = Pix::where('token', $token)->firstOrFail();

        return response(
            QrCode::format('png')
                ->size(300)
                ->backgroundColor(255, 255, 255)
                ->color(0, 0, 0)
                ->generate($pix->getPaymentLink())
        )->header('Content-Type', 'image/png');
    }

    public function show(string $token): JsonResponse
    {
        $pix = Pix::where('token', $token)->with('user')->firstOrFail();

        if ($pix->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($pix->getShareableData());
    }

    public function stats(): JsonResponse
    {
        $user = Auth::user();

        $stats = $user->pix()
            ->selectRaw('
                COUNT(*) as total,
                SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as paid,
                SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as expired,
                SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as generated
            ', [Pix::STATUS_PAID, Pix::STATUS_EXPIRED, Pix::STATUS_GENERATED])
            ->first();

        return response()->json([
            'total' => (int) $stats->total,
            'paid' => (int) $stats->paid,
            'expired' => (int) $stats->expired,
            'generated' => (int) $stats->generated,
        ]);
    }

    public function checkStatusPixMonitoring(string $token): Response
    {
        $pix = Pix::where('token', $token)->with('user')->firstOrFail();

        if ($pix->isExpired() && $pix->status === Pix::STATUS_GENERATED) {
            $pix->markAsExpired();
        } elseif ($pix->status === Pix::STATUS_PAID) {
            return Inertia::render('Pix/Success', [

            ]);
        }
    }

    public function storeList(array $pixList, string $userId, int $expirationTime)
    {
        $createdPixes = [];
        foreach($pixList as $emailList){
            $pix = Pix::create([
            'user_id' =>$userId,
            'expires_at' => now()->addMinutes($expirationTime),
        ]);

        $pix->sendCreationNotification();
        $createdPixes[]=$pix->getShareableData();
        }
        return $createdPixes;
    }
}
