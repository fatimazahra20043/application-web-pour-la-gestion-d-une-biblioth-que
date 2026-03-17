<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controller responsible for managing
 * user reservations on the public side
 */
class ReservationController extends Controller
{
    /**
     * Create a new reservation for a book
     */
    public function store(Request $request, Book $book)
    {
        // Check if the book is available
        if ($book->available <= 0) {
            return back()->with('error', 'Ce livre n\'est pas disponible.');
        }

        // Validate reservation dates
        $validated = $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Create the reservation with status 'pending'
        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'status' => 'pending',
            'reservation_date' => now(),
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
        ]);

        // Decrement book availability
        $book->decrement('available');

        return redirect()->route('reservations.index')
            ->with('success', 'Réservation créée avec succès. En attente de confirmation.');
    }

    /**
     * Display the list of reservations for the logged-in user
     */
    public function index()
    {
        // Retrieve reservations with related book data
        $reservations = Reservation::where('user_id', Auth::id())
            ->with('book')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('reservations.index', compact('reservations'));
    }
}
