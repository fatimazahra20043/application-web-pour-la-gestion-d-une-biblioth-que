<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\User;
use App\Models\Reservation;

/**
 * Controller responsible for displaying
 * statistics and recent activity on the admin dashboard
 */
class DashboardController extends Controller
{
    /**
     * Display the admin dashboard with system statistics
     */
    public function index()
    {
        // Global statistics displayed on the dashboard
        $stats = [
            // Total number of books in the system
            'total_books' => Book::count(),

            // Total number of users (excluding admins)
            'total_users' => User::where('role', 'user')->count(),

            // Number of pending reservations
            'pending_reservations' => Reservation::where('status', 'pending')->count(),

            // Number of confirmed (active) reservations
            'active_reservations' => Reservation::where('status', 'confirmed')->count(),
        ];

        // Retrieve the 5 most recent reservations with related user and book data
        $recent_reservations = Reservation::with(['user', 'book'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Return dashboard view with statistics and recent reservations
        return view('admin.dashboard', compact('stats', 'recent_reservations'));
    }
}
