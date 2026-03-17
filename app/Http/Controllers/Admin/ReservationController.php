<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Controller responsible for managing reservations
 * in the admin panel
 */
class ReservationController extends Controller
{
    /**
     * Display a paginated list of reservations
     */
    public function index()
    {
        // Retrieve reservations with related user and book data
        $reservations = Reservation::with(['user', 'book'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.reservations.index', compact('reservations'));
    }

    /**
     * Search for a reservation using its confirmation code
     */
    public function searchByCode(Request $request)
    {
        // Validate the confirmation code
        $request->validate([
            'code' => 'required|string|size:8',
        ]);

        // Find reservation by confirmation code
        $reservation = Reservation::where(
                'confirmation_code',
                strtoupper($request->code)
            )
            ->with(['user', 'book'])
            ->first();

        // If no reservation found, return with error message
        if (!$reservation) {
            return back()->with(
                'error',
                'Aucune réservation trouvée avec ce code.'
            );
        }

        return view(
            'admin.reservations.search-result',
            compact('reservation')
        );
    }

    /**
     * Confirm a reservation and generate a confirmation code
     */
    public function confirm(Reservation $reservation)
    {
        // Update reservation status and generate confirmation code
        $reservation->update([
            'status' => 'confirmed',
            'confirmation_code' => strtoupper(Str::random(8)),
        ]);

        // Notify the user that the reservation has been confirmed
        NotificationService::reservationConfirmed($reservation);

        return back()->with(
            'success',
            'Réservation confirmée avec le code: ' . $reservation->confirmation_code
        );
    }

    /**
     * Cancel (refuse) a reservation with a reason
     */
    public function cancel(Request $request, Reservation $reservation)
    {
        // Validate refusal reason and optional admin notes
        $request->validate([
            'refusal_reason' => 'required|string',
            'admin_notes' => 'nullable|string',
        ]);

        // Update reservation status and store admin notes
        $reservation->update([
            'status' => 'cancelled',
            'refusal_reason' => $request->refusal_reason,
            'admin_notes' => $request->admin_notes,
        ]);

        // Restore book availability
        $reservation->book->increment('available');

        // Notify the user that the reservation was refused
        NotificationService::reservationRefused(
            $reservation,
            $request->refusal_reason
        );

        return back()->with('success', 'Réservation refusée.');
    }

    /**
     * Display reservation details and user statistics
     */
    public function show(Reservation $reservation)
    {
        $user = $reservation->user;

        // Calculate statistics related to the user
        $userStats = [
            'total_reservations' => $user->reservations()->count(),
            'on_time_returns' => $user->on_time_returns,
            'late_returns' => $user->late_returns,
            'damaged_books' => $user->damaged_books,
            'conformity_rate' => $user->conformity_rate,
            'recent_reservations' => $user->reservations()
                ->with('book')
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get(),
        ];

        return view(
            'admin.reservations.show',
            compact('reservation', 'userStats')
        );
    }

    /**
     * Register the return of a borrowed book
     */
    public function returnBook(Request $request, Reservation $reservation)
    {
        // Validate book condition and optional admin notes
        $request->validate([
            'book_condition' => 'required|in:good,damaged,lost',
            'admin_notes' => 'nullable|string',
        ]);

        $user = $reservation->user;

        // Check if the book is returned late
        $isLate = $reservation->isLate();

        // Update reservation return information
        $reservation->update([
            'status' => 'returned',
            'returned_at' => now(),
            'book_condition' => $request->book_condition,
            'admin_notes' => $request->admin_notes,
        ]);

        // Increase available book quantity
        $reservation->book->increment('available');

        // Update user return statistics
        if ($isLate) {
            $user->increment('late_returns');
        } else {
            $user->increment('on_time_returns');
        }

        // Update damaged or lost books count
        if ($request->book_condition === 'damaged') {
            $user->increment('damaged_books');
        } elseif ($request->book_condition === 'lost') {
            $user->increment('lost_books');
        }

        return back()->with('success', 'Retour enregistré avec succès.');
    }

    /**
     * Add an internal admin note to a reservation
     */
    public function addNote(Request $request, Reservation $reservation)
    {
        // Validate admin note content
        $request->validate([
            'admin_notes' => 'required|string',
        ]);

        // Append the new note with a timestamp
        $reservation->update([
            'admin_notes' => $reservation->admin_notes
                ? $reservation->admin_notes . "\n\n[" . now()->format('d/m/Y H:i') . "] " . $request->admin_notes
                : "[" . now()->format('d/m/Y H:i') . "] " . $request->admin_notes,
        ]);

        return back()->with('success', 'Note ajoutée avec succès.');
    }
}
