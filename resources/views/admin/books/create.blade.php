@extends('layouts.app')

@section('title', 'Ajouter un livre')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <a href="{{ route('admin.books.index') }}" class="btn-outline mb-3">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
        
        <div class="modern-card">
            <div class="card-header-modern">
                <h4 class="mb-0">Ajouter un nouveau livre</h4>
            </div>
            <div class="p-4">
                {{-- Added enctype for file upload --}}
                <form method="POST" action="{{ route('admin.books.store') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-group-modern">
                        <label for="title" class="form-label-modern">Titre *</label>
                        <input type="text" class="form-input-modern @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group-modern">
                        <label for="author" class="form-label-modern">Auteur *</label>
                        <input type="text" class="form-input-modern @error('author') is-invalid @enderror" 
                               id="author" name="author" value="{{ old('author') }}" required>
                        @error('author')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group-modern">
                        <label for="isbn" class="form-label-modern">ISBN *</label>
                        <input type="text" class="form-input-modern @error('isbn') is-invalid @enderror" 
                               id="isbn" name="isbn" value="{{ old('isbn') }}" required>
                        @error('isbn')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group-modern">
                        <label for="category_id" class="form-label-modern">Catégorie *</label>
                        <select class="form-input-modern @error('category_id') is-invalid @enderror" 
                                id="category_id" name="category_id" required>
                            <option value="">Sélectionner une catégorie</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group-modern">
                        <label for="quantity" class="form-label-modern">Quantité *</label>
                        <input type="number" class="form-input-modern @error('quantity') is-invalid @enderror" 
                               id="quantity" name="quantity" value="{{ old('quantity', 1) }}" min="1" required>
                        @error('quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Added image upload field --}}
                    <div class="form-group-modern">
                        <label for="cover_image" class="form-label-modern">Image de couverture</label>
                        <input type="file" class="form-input-modern @error('cover_image') is-invalid @enderror" 
                               id="cover_image" name="cover_image" accept="image/*">
                        <small class="text-muted">Formats acceptés: JPG, PNG, GIF (Max: 2MB)</small>
                        @error('cover_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group-modern">
                        <label for="description" class="form-label-modern">Description</label>
                        <textarea class="form-input-modern @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn-coral">
                        <i class="bi bi-check-lg"></i> Enregistrer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
