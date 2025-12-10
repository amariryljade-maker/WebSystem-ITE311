<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Application Logs</h1>
                <div>
                    <form method="GET" action="/logs" class="d-inline-block me-2">
                        <div class="input-group input-group-sm">
                            <input type="number" name="lines" class="form-control" value="<?= $requested_lines ?>" 
                                   min="10" max="1000" step="10" placeholder="Lines">
                            <button type="submit" class="btn btn-outline-primary">Show</button>
                        </div>
                    </form>
                    <form method="POST" action="/logs/clear" class="d-inline-block" 
                          onsubmit="return confirm('Are you sure you want to clear all logs?')">
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i> Clear Logs
                        </button>
                    </form>
                </div>
            </div>

            <!-- Log Stats -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="d-flex align-items-center">
                                <span class="badge bg-primary me-2">TOTAL</span>
                                <span class="fw-bold"><?= $total_lines ?> lines</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex align-items-center">
                                <span class="badge bg-danger me-2">ERROR</span>
                                <span class="fw-bold"><?= count(array_filter($logs, fn($l) => $l['level'] === 'ERROR')) ?></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex align-items-center">
                                <span class="badge bg-warning me-2">WARNING</span>
                                <span class="fw-bold"><?= count(array_filter($logs, fn($l) => $l['level'] === 'WARNING')) ?></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex align-items-center">
                                <span class="badge bg-info me-2">INFO</span>
                                <span class="fw-bold"><?= count(array_filter($logs, fn($l) => $l['level'] === 'INFO')) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Log Entries -->
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Log Entries</h6>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($logs)): ?>
                        <div class="p-4 text-center text-muted">
                            <i class="fas fa-info-circle fa-3x mb-3"></i>
                            <p>No log entries found.</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="150">Timestamp</th>
                                        <th width="80">Level</th>
                                        <th>Message</th>
                                        <th width="80">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($logs as $index => $log): ?>
                                        <tr>
                                            <td>
                                                <small class="text-muted"><?= $log['timestamp'] ?></small>
                                            </td>
                                            <td>
                                                <?php
                                                $badgeClass = 'bg-light text-dark'; // default
                                                switch($log['level']) {
                                                    case 'ERROR':
                                                        $badgeClass = 'bg-danger';
                                                        break;
                                                    case 'WARNING':
                                                        $badgeClass = 'bg-warning';
                                                        break;
                                                    case 'INFO':
                                                        $badgeClass = 'bg-info';
                                                        break;
                                                    case 'DEBUG':
                                                        $badgeClass = 'bg-secondary';
                                                        break;
                                                }
                                                ?>
                                                <span class="badge <?= $badgeClass ?>"><?= $log['level'] ?></span>
                                            </td>
                                            <td>
                                                <div class="log-message">
                                                    <?= esc($log['message']) ?>
                                                    
                                                    <?php if (!empty($log['context'])): ?>
                                                        <button class="btn btn-sm btn-link p-0 ms-2" 
                                                                type="button" data-bs-toggle="collapse" 
                                                                data-bs-target="#context-<?= $index ?>">
                                                            <small><i class="fas fa-code"></i> context</small>
                                                        </button>
                                                        
                                                        <div class="collapse mt-2" id="context-<?= $index ?>">
                                                            <div class="card card-body bg-light">
                                                                <pre class="mb-0 small"><?= json_encode($log['context'], JSON_PRETTY_PRINT) ?></pre>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-secondary" 
                                                        type="button" data-bs-toggle="modal" 
                                                        data-bs-target="#logModal-<?= $index ?>">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        
                                        <!-- Modal for full log view -->
                                        <div class="modal fade" id="logModal-<?= $index ?>" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            Log Entry - <?= $log['timestamp'] ?>
                                                            <span class="badge <?= $badgeClass ?> ms-2"><?= $log['level'] ?></span>
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <strong>Message:</strong>
                                                            <p class="mb-2"><?= esc($log['message']) ?></p>
                                                        </div>
                                                        
                                                        <?php if (!empty($log['context'])): ?>
                                                            <div class="mb-3">
                                                                <strong>Context:</strong>
                                                                <pre class="bg-light p-2 rounded"><?= json_encode($log['context'], JSON_PRETTY_PRINT) ?></pre>
                                                            </div>
                                                        <?php endif; ?>
                                                        
                                                        <div>
                                                            <strong>Raw Log:</strong>
                                                            <pre class="bg-dark text-light p-2 rounded small"><?= esc($log['raw']) ?></pre>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.log-message {
    max-width: 500px;
    word-wrap: break-word;
}
</style>
<?= $this->endSection() ?>
