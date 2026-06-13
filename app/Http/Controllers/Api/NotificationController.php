<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Mengambil daftar notifikasi milik user aktif
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Ambil notifikasi dari yang paling baru (latest)
        $notifications = Notification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(30) // Batasi maksimal 30 notifikasi agar load aplikasi cepat
            ->get();

        // Transformasi struktur data (Mapping) agar pas dengan model Flutter
        $dataTransformed = $notifications->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                // created_at diubah menjadi string waktu, misal "4:40 PM" atau "11:15 AM"
                'time' => $item->created_at->timezone('Asia/Jakarta')->format('g:i A'),
                'icon' => $item->icon,
                'icon_color' => $item->icon_color,
                'is_read' => $item->is_read
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $dataTransformed
        ], 200);
    }
}