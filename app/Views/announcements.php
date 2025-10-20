<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="display-4">
                    <i class="bi bi-megaphone"></i> Announcements
                </h1>
            </div>

            <?php if (empty($announcements)): ?>
                <!-- Empty State -->
                <div class="alert alert-info" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-info-circle fs-3 me-3"></i>
                        <div>
                            <h5 class="alert-heading mb-1">No Announcements Yet</h5>
                            <p class="mb-0">There are currently no announcements to display. Check back later for updates!</p>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- Announcements List -->
                <div class="row">
                    <?php foreach ($announcements as $announcement): ?>
                        <div class="col-12 mb-4">
                            <div class="card shadow-sm h-100 border-0">
                                <div class="card-header bg-primary text-white">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">
                                            <i class="bi bi-bell"></i> 
                                            <?= esc($announcement['title']) ?>
                                        </h5>
                                        <small class="opacity-75">
                                            <i class="bi bi-calendar-event"></i>
                                            <?= date('M d, Y - h:i A', strtotime($announcement['date_posted'])) ?>
                                        </small>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="announcement-content">
                                        <?= nl2br(esc($announcement['content'])) ?>
                                    </div>
                                </div>
                                <div class="card-footer bg-light text-muted">
                                    <small>
                                        <i class="bi bi-clock-history"></i> 
                                        Posted <?= date('F j, Y \a\t g:i A', strtotime($announcement['date_posted'])) ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Total Count -->
                <div class="alert alert-light mt-3" role="alert">
                    <i class="bi bi-list-check"></i> 
                    Showing <strong><?= count($announcements) ?></strong> announcement<?= count($announcements) !== 1 ? 's' : '' ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .announcement-content {
        font-size: 1.05rem;
        line-height: 1.6;
        color: #333;
    }

    .card {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.15) !important;
    }

    .card-header {
        border-bottom: 3px solid rgba(255,255,255,0.2);
    }

    .card-footer {
        border-top: 1px solid rgba(0,0,0,0.05);
    }
</style>

