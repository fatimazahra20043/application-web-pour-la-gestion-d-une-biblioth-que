<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Controller responsible for managing books in the admin panel
 */
class BookController extends Controller
{
    /**
     * Display a paginated list of books with their categories
     */
    public function index()
    {
        // Retrieve books with their associated category (Eloquent relationship)
        $books = Book::with('category')->paginate(15);

        // Return the admin view with the books data
        return view('admin.books.index', compact('books'));
    }

    /**
     * Show the form to create a new book
     */
    public function create()
    {
        // Retrieve all categories to show them in a dropdown
        $categories = Category::all();

        return view('admin.books.create', compact('categories'));
    }

    /**
     * Store a newly created book in the database
     */
    public function store(Request $request)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'quantity' => 'required|integer|min:1',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Set available copies equal to total quantity
        $validated['available'] = $validated['quantity'];

        // Handle cover image upload if provided
        if ($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');

            // Define upload path
            $uploadPath = public_path('images/books');

            // Create directory if it does not exist
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Generate unique image name
            $imageName = time() . '_' . $image->getClientOriginalName();

            // Move image to public directory
            $image->move($uploadPath, $imageName);

            // Save image path in database
            $validated['cover_image'] = 'images/books/' . $imageName;

            // Log image path for debugging
            Log::info('Book image saved: ' . $validated['cover_image']);
        }

        // Create the book record in the database
        Book::create($validated);

        // Redirect back with success message
        return redirect()->route('admin.books.index')
            ->with('success', 'Livre ajouté avec succès.');
    }

    /**
     * Show the form to edit an existing book
     */
    public function edit(Book $book)
    {
        // Retrieve all categories for selection
        $categories = Category::all();

        return view('admin.books.edit', compact('book', 'categories'));
    }

    /**
     * Update an existing book in the database
     */
    public function update(Request $request, Book $book)
    {
        // Validate request data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn,' . $book->id,
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'quantity' => 'required|integer|min:1',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle new cover image upload
        if ($request->hasFile('cover_image')) {

            // Delete old image if it exists
            if ($book->cover_image && file_exists(public_path($book->cover_image))) {
                unlink(public_path($book->cover_image));
            }

            // Define upload directory
            $uploadPath = public_path('images/books');

            // Create directory if missing
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Save new image
            $image = $request->file('cover_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move($uploadPath, $imageName);

            $validated['cover_image'] = 'images/books/' . $imageName;

            // Log updated image path
            Log::info('Book image updated: ' . $validated['cover_image']);
        }

        // Update book data
        $book->update($validated);

        return redirect()->route('admin.books.index')
            ->with('success', 'Livre modifié avec succès.');
    }

    /**
     * Delete a book if it has no active reservations
     */
    public function destroy(Book $book)
    {
        // Count active reservations related to this book
        $activeReservations = $book->reservations()
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();

        // Prevent deletion if reservations exist
        if ($activeReservations > 0) {
            return back()->with(
                'error',
                'Impossible de supprimer ce livre car il a des réservations actives.'
            );
        }

        // Delete the book
        $book->delete();

        return redirect()->route('admin.books.index')
            ->with('success', 'Livre supprimé avec succès.');
    }
}
