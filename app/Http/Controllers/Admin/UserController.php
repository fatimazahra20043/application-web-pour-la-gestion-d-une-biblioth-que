<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Controller responsible for managing users
 * in the admin panel
 */
class UserController extends Controller
{
    /**
     * Display a paginated list of users
     */
    public function index()
    {
        // Retrieve users with pagination
        $users = User::paginate(15);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form to create a new user
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in the database
     */
    public function store(Request $request)
    {
        // Validate user input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:user,admin',
            'notes' => 'nullable|string',
        ]);

        // Hash password before saving
        $validated['password'] = Hash::make($validated['password']);

        // Create user record
        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur ajouté avec succès.');
    }

    /**
     * Show the form to edit an existing user
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update user information
     */
    public function update(Request $request, User $user)
    {
        // Validate updated user data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:user,admin',
            'notes' => 'nullable|string',
        ]);

        // Update password only if provided
        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8|confirmed']);
            $validated['password'] = Hash::make($request->password);
        }

        // Update user record
        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur modifié avec succès.');
    }

    /**
     * Delete a user
     */
    public function destroy(User $user)
{
    // Vérifier si l'utilisateur a des réservations
    if ($user->reservations()->exists()) {
        return redirect()->route('admin.users.index')
            ->with('error', 'Impossible de supprimer l\'utilisateur car il a des réservations en cours.');
    }

    $user->delete();
    return redirect()->route('admin.users.index')
        ->with('success', 'Utilisateur supprimé avec succès.');
}

    /**
     * Display user profile with reservation history and statistics
     */
    public function show(User $user)
    {
        // Retrieve all reservations made by the user
        $reservations = $user->reservations()
            ->with('book')
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate user-related statistics
        $userStats = [
            'total_reservations' => $user->reservations()->count(),
            'pending_reservations' => $user->reservations()->where('status', 'pending')->count(),
            'confirmed_reservations' => $user->reservations()->where('status', 'confirmed')->count(),
            'returned_reservations' => $user->reservations()->where('status', 'returned')->count(),
            'on_time_returns' => $user->on_time_returns,
            'late_returns' => $user->late_returns,
            'damaged_books' => $user->damaged_books,
            'lost_books' => $user->lost_books,
            'conformity_rate' => $user->conformity_rate,
        ];

        return view(
            'admin.users.show',
            compact('user', 'userStats', 'reservations')
        );
    }

    /**
     * Manually update user statistics (admin action)
     */
    public function updateStatistics(Request $request, User $user)
    {
        // Validate statistics input
        $request->validate([
            'total_reservations' => 'required|integer|min:0',
            'on_time_returns' => 'required|integer|min:0',
            'late_returns' => 'required|integer|min:0',
            'damaged_books' => 'required|integer|min:0',
            'lost_books' => 'required|integer|min:0',
        ]);

        // Update statistics fields
        $user->update([
            'total_reservations' => $request->total_reservations,
            'on_time_returns' => $request->on_time_returns,
            'late_returns' => $request->late_returns,
            'damaged_books' => $request->damaged_books,
            'lost_books' => $request->lost_books,
        ]);

        return back()->with('success', 'Statistiques mises à jour avec succès.');
    }

    /**
     * Add or update internal admin notes for a user
     */
    public function updateNotes(Request $request, User $user)
    {
        // Validate notes input
        $request->validate([
            'notes' => 'nullable|string',
        ]);

        // Append new note with timestamp
        $currentNotes = $user->notes ?? '';
        $newNote = "[" . now()->format('d/m/Y H:i') . "] " . $request->notes;

        $user->update([
            'notes' => $currentNotes
                ? $currentNotes . "\n\n" . $newNote
                : $newNote,
        ]);

        return back()->with('success', 'Note ajoutée avec succès.');
    }
}
