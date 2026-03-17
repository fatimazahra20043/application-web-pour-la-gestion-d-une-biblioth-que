<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

/**
 * Controller responsible for managing book categories
 * in the admin panel
 */
class CategoryController extends Controller
{
    /**
     * Display a paginated list of categories
     * with the number of books in each category
     */
    public function index()
    {
        // Retrieve categories with a count of related books
        $categories = Category::withCount('books')->paginate(15);

        // Return the index view with categories data
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form to create a new category
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created category in the database
     */
    public function store(Request $request)
    {
        // Validate form input
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
        ]);

        // Create category record
        Category::create($validated);

        // Redirect with success message
        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie ajoutée avec succès.');
    }

    /**
     * Show the form to edit an existing category
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the selected category
     */
    public function update(Request $request, Category $category)
    {
        // Validate updated data
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);

        // Update category information
        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie modifiée avec succès.');
    }

    /**
     * Delete a category if it contains no books
     */
    public function destroy(Category $category)
    {
        // Prevent deletion if the category has associated books
        if ($category->books()->count() > 0) {
            return back()->with(
                'error',
                'Impossible de supprimer une catégorie contenant des livres.'
            );
        }

        // Delete category
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie supprimée avec succès.');
    }
}
