<?php

namespace App\Http\Controllers;

use App\Models\Pix;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\User;

class GeneratePixChargeController extends Controller
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

        $usersList = $this->browseUsers();

        return Inertia::render('GeneratePixCharge', [
            'usersList' => $usersList,
            'pixStats' => $pixStats,
            'recentPix' => $recentPix,
        ]);
    }

    public function browseUsers()
    {
        $users = User::all()->toArray();
        $usersListFilter = [];

        foreach($users as $user){
            $usersListFilter[] = [
                'name' => $user["name"],
                'items' =>[[
                    'name' => $user["name"],
                    'email' => $user["email"],
                    'created_at' => $user["created_at"]
                ]
                    ]
                ];
        }
        
        return $usersListFilter;
    }

    public function browsePixes(): Response
    {
        return Inertia::render('MyPixes', []);
    }
    
    /**
     * Renders the detailed view for a specific Pix transaction.
     * 
     * @return Response Inertia response rendering the 'MyPixDetails' page
     */
    public function showPixDetail(): Response
    {
        return Inertia::render('MyPixDetail');
    }
    
}
