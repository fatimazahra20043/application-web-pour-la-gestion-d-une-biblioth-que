<?php $__env->startSection('title', 'Gestion des livres'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="fw-bold mb-0"><i class="bi bi-book"></i> Gestion des livres</h1>
    <a href="<?php echo e(route('admin.books.create')); ?>" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Ajouter un livre
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Auteur</th>
                        <th>ISBN</th>
                        <th>Catégorie</th>
                        <th>Quantité</th>
                        <th>Disponible</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="fw-semibold"><?php echo e($book->title); ?></td>
                            <td><?php echo e($book->author); ?></td>
                            <td><code><?php echo e($book->isbn); ?></code></td>
                            <td><span class="badge bg-primary"><?php echo e($book->category->name); ?></span></td>
                            <td><?php echo e($book->quantity); ?></td>
                            <td>
                                <?php if($book->available > 0): ?>
                                    <span class="badge bg-success"><?php echo e($book->available); ?></span>
                                <?php else: ?>
                                    <span class="badge bg-danger">0</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="<?php echo e(route('admin.books.edit', $book)); ?>" class="btn btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="<?php echo e(route('admin.books.destroy', $book)); ?>" 
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce livre ?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">Aucun livre trouvé</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    <?php echo e($books->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laravel_projects\university_biblio_project\resources\views/admin/books/index.blade.php ENDPATH**/ ?>