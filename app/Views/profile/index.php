<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">My Profile</h1>
                <div>
                    <a href="<?= base_url('profile/edit') ?>" class="btn btn-primary me-2">
                        <i class="fas fa-edit me-1"></i>Edit Profile
                    </a>
                    <a href="<?= base_url('profile/change-password') ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-key me-1"></i>Change Password
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <div class="mb-3">
                                <img src="https://via.placeholder.com/150x150/4e73df/ffffff?text=<?= substr($user['name'], 0, 2) ?>" 
                                     class="rounded-circle" alt="Profile Avatar" width="150" height="150">
                            </div>
                            <h5 class="card-title"><?= esc($user['name']) ?></h5>
                            <p class="card-text text-muted"><?= esc($user['email']) ?></p>
                            <span class="badge bg-primary"><?= ucfirst($user['role']) ?></span>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-primary">Profile Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Full Name</label>
                                        <p class="form-control-plaintext"><?= esc($user['name']) ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Email Address</label>
                                        <p class="form-control-plaintext"><?= esc($user['email']) ?></p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Role</label>
                                        <p class="form-control-plaintext">
                                            <span class="badge bg-<?= $user['role'] == 'admin' ? 'danger' : ($user['role'] == 'teacher' ? 'success' : 'info') ?>">
                                                <?= ucfirst($user['role']) ?>
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Member Since</label>
                                        <p class="form-control-plaintext"><?= date('F j, Y', strtotime($user['created_at'])) ?></p>
                                    </div>
                                </div>
                            </div>

                            <?php if (isset($user['last_login'])): ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Last Login</label>
                                        <p class="form-control-plaintext"><?= date('M j, Y H:i', strtotime($user['last_login'])) ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-primary">Account Settings</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-2">
                                <a href="<?= base_url('profile/edit') ?>" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-user-edit me-1"></i>Edit Information
                                </a>
                                <a href="<?= base_url('profile/change-password') ?>" class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-lock me-1"></i>Change Password
                                </a>
                                <a href="<?= base_url('notifications') ?>" class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-bell me-1"></i>Notifications
                                </a>
                                <a href="<?= base_url('logout') ?>" class="btn btn-outline-danger btn-sm">
                                    <i class="fas fa-sign-out-alt me-1"></i>Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
