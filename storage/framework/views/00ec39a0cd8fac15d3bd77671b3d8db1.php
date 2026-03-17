<?php $__env->startSection('title', 'Dashboard Admin'); ?>

<?php $__env->startSection('content'); ?>
<!-- Updated with new stat card design matching coral theme -->
<div class="mb-5">
    <h2 class="section-title">Dashboard Administrateur</h2>
    <p class="section-subtitle">Vue d'ensemble de votre bibliothèque</p>
</div>

<div class="row mb-5">
    <div class="col-md-3 mb-4">
        <div class="stat-card">
            <div class="stat-value"><?php echo e($stats['total_books']); ?></div>
            <div class="stat-label"><i class="bi bi-book-fill"></i> Total Livres</div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="stat-card" style="border-left-color: #2ecc71;">
            <div class="stat-value" style="color: #2ecc71;"><?php echo e($stats['total_users']); ?></div>
            <div class="stat-label"><i class="bi bi-people-fill"></i> Utilisateurs</div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="stat-card" style="border-left-color: var(--orange);">
            <div class="stat-value" style="color: var(--orange);"><?php echo e($stats['pending_reservations']); ?></div>
            <div class="stat-label"><i class="bi bi-clock-fill"></i> En attente</div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="stat-card" style="border-left-color: var(--navy-light);">
            <div class="stat-value" style="color: var(--navy-light);"><?php echo e($stats['active_reservations']); ?></div>
            <div class="stat-label"><i class="bi bi-check-circle-fill"></i> Actives</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="bi bi-calendar-check"></i> Réservations récentes
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Livre</th>
                        <th>Date</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $recent_reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><strong><?php echo e($reservation->user->name); ?></strong></td>
                            <td><?php echo e($reservation->book->title); ?></td>
                            <td><?php echo e($reservation->created_at->format('d/m/Y H:i')); ?></td>
                            <td>
                                <?php if($reservation->status === 'pending'): ?>
                                    <span class="badge bg-warning">En attente</span>
                                <?php elseif($reservation->status === 'confirmed'): ?>
                                    <span class="badge bg-success">Confirmée</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Annulée</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?php echo e(route('admin.reservations.show', $reservation)); ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">Aucune réservation récente</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laravel_projects\university_biblio_project\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>