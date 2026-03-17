<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controller responsible for managing
 * user's favorite books
 */
class FavoriteController extends Controller
{
    /**
     * Display the list of favorite books
     * for the authenticated user
     */
    public function index()
    {
        // Retrieve favorites belonging to the logged-in user
        // and load related book and category data
        $favorites = Favorite::where('user_id', Auth::id())
            ->with('book.category')
            ->paginate(12);

        return view('favorites.index', compact('favorites'));
    }

    /**
     * Add a book to the user's favorites
     */
    public function store(Book $book)
    {
        // Create favorite if it does not already exist
        Favorite::firstOrCreate([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
        ]);

        return back()->with('success', 'Livre ajouté aux favoris.');
    }

    /**
     * Remove a book from the user's favorites
     */
    public function destroy(Book $book)
    {
        // Delete the favorite record for the current user and selected book
        Favorite::where('user_id', Auth::id())
            ->where('book_id', $book->id)
            ->delete();

        return back()->with('success', 'Livre retiré des favoris.');
    }
}
