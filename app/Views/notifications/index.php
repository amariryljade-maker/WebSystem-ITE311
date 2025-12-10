<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Notifications</h1>
                <div>
                    <?php if ($unread_count > 0): ?>
                        <a href="<?= base_url('notifications/mark-all-read') ?>" class="btn btn-outline-primary btn-sm me-2">
                            <i class="fas fa-check-double me-1"></i>Mark All Read
                        </a>
                    <?php endif; ?>
                    <span class="badge bg-<?= $unread_count > 0 ? 'danger' : 'secondary' ?>">
                        <?= $unread_count ?> unread
                    </span>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Your Notifications</h6>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($notifications)): ?>
                        <div class="p-4 text-center text-muted">
                            <i class="fas fa-bell-slash fa-3x mb-3"></i>
                            <p>No notifications found.</p>
                        </div>
                    <?php else: ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($notifications as $notification): ?>
                                <div class="list-group-item list-group-item-action <?= $notification['is_read'] ? '' : 'bg-light' ?>">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">
                                            <?= esc($notification['title']) ?>
                                            <?php if (!$notification['is_read']): ?>
                                                <span class="badge bg-primary ms-2">New</span>
                                            <?php endif; ?>
                                        </h6>
                                        <small class="text-muted">
                                            <?= date('M j, Y H:i', strtotime($notification['created_at'])) ?>
                                        </small>
                                    </div>
                                    <p class="mb-1"><?= esc($notification['message']) ?></p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            Type: <span class="badge bg-<?= $badge_class($notification['type']) ?>">
                                                <?= ucfirst($notification['type']) ?>
                                            </span>
                                        </small>
                                        <?php if (!$notification['is_read']): ?>
                                            <a href="<?= base_url('notifications/mark-read/' . $notification['id']) ?>" 
                                               class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-check me-1"></i>Mark as Read
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <!-- Pagination -->
                        <?php if ($total > $per_page): ?>
                            <div class="card-footer">
                                <nav>
                                    <ul class="pagination pagination-sm mb-0 justify-content-center">
                                        <?php
                                        $totalPages = ceil($total / $per_page);
                                        for ($i = 1; $i <= $totalPages; $i++):
                                        ?>
                                            <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                                                <a class="page-link" href="<?= base_url('notifications?page=' . $i) ?>">
                                                    <?= $i ?>
                                                </a>
                                            </li>
                                        <?php endfor; ?>
                                    </ul>
                                </nav>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

?>
<?= $this->endSection() ?>
