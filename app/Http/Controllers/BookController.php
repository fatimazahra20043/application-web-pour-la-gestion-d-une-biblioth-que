<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

/**
 * Controller responsible for displaying books
 * to users (public side)
 */
class BookController extends Controller
{
    /**
     * Display a list of books with search and category filters
     */
    public function index(Request $request)
    {
        // Initialize query with related category data
        $query = Book::with('category');

        // Filter books by title (search functionality)
        if ($request->filled('search')) {
            $query->where(
                'title',
                'like',
                '%' . $request->search . '%'
            );
        }

        // Filter books by selected category
        if ($request->filled('category')) {
            $query->where(
                'category_id',
                $request->category
            );
        }

        // Paginate results (12 books per page)
        $books = $query->paginate(12);

        // Retrieve all categories for the filter dropdown
        $categories = Category::all();

        // Return the books listing view
        return view(
            'books.index',
            compact('books', 'categories')
        );
    }

    /**
     * Display details of a single book
     */
    public function show(Book $book)
    {
        // Load related category information
        $book->load('category');

        return view('books.show', compact('book'));
    }
}
