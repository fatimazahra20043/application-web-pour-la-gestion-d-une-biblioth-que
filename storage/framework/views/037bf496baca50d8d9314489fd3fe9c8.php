<?php $__env->startSection('title', 'Mes favoris'); ?>

<?php $__env->startSection('content'); ?>
<h1 class="page-title mb-4"><i class="bi bi-heart-fill"></i> Mes favoris</h1>

<div class="books-grid">
    <?php $__empty_1 = true; $__currentLoopData = $favorites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $favorite): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="book-card">
            <!-- Fixed image path to use asset() and check file existence -->
            <div class="book-cover">
                <?php if($favorite->book->cover_image && file_exists(public_path($favorite->book->cover_image))): ?>
                    <img src="<?php echo e(asset($favorite->book->cover_image)); ?>" alt="<?php echo e($favorite->book->title); ?>" class="img-fluid">
                <?php else: ?>
                    <div class="book-placeholder">
                        <i class="bi bi-book"></i>
                    </div>
                <?php endif; ?>
            </div>
            <div class="book-info">
                <div class="book-badges">
                    <span class="badge-navy"><?php echo e($favorite->book->category->name); ?></span>
                </div>
                
                <h5 class="book-title"><?php echo e($favorite->book->title); ?></h5>
                <p class="book-author">
                    <i class="bi bi-person"></i> <?php echo e($favorite->book->author); ?>

                </p>
                
                <div class="book-actions">
                    <a href="<?php echo e(route('books.show', $favorite->book)); ?>" class="btn btn-primary btn-sm flex-fill">
                        <i class="bi bi-eye"></i> Voir
                    </a>
                    
                    <form method="POST" action="<?php echo e(route('favorites.destroy', $favorite->book)); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-12">
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> Vous n'avez pas encore de livres favoris.
            </div>
        </div>
    <?php endif; ?>
</div>

<div class="d-flex justify-content-center mt-4">
    <?php echo e($favorites->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laravel_projects\university_biblio_project\resources\views/favorites/index.blade.php ENDPATH**/ ?>