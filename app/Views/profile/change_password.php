<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Change Password</h1>
                <a href="<?= base_url('profile') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Back to Profile
                </a>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-primary">Change Your Password</h6>
                        </div>
                        <div class="card-body">
                            <?php if (session()->getFlashdata('error')): ?>
                                <div class="alert alert-danger">
                                    <?= session()->getFlashdata('error') ?>
                                </div>
                            <?php endif; ?>

                            <?php if (session()->getFlashdata('success')): ?>
                                <div class="alert alert-success">
                                    <?= session()->getFlashdata('success') ?>
                                </div>
                            <?php endif; ?>

                            <form action="<?= base_url('profile/change-password') ?>" method="post">
                                
                                <div class="form-group mb-3">
                                    <label for="current_password">Current Password *</label>
                                    <input type="password" class="form-control" id="current_password" 
                                           name="current_password" required>
                                    <?php if ($validation->getError('current_password')): ?>
                                        <div class="text-danger"><?= $validation->getError('current_password') ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="new_password">New Password *</label>
                                    <input type="password" class="form-control" id="new_password" 
                                           name="new_password" required minlength="8">
                                    <?php if ($validation->getError('new_password')): ?>
                                        <div class="text-danger"><?= $validation->getError('new_password') ?></div>
                                    <?php endif; ?>
                                    <small class="form-text text-muted">
                                        Password must be at least 8 characters long.
                                    </small>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="confirm_password">Confirm New Password *</label>
                                    <input type="password" class="form-control" id="confirm_password" 
                                           name="confirm_password" required>
                                    <?php if ($validation->getError('confirm_password')): ?>
                                        <div class="text-danger"><?= $validation->getError('confirm_password') ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Security Tips:</strong>
                                    <ul class="mb-0 mt-2">
                                        <li>Use a strong password with letters, numbers, and symbols</li>
                                        <li>Don't reuse passwords from other accounts</li>
                                        <li>Change your password regularly</li>
                                    </ul>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-key me-1"></i>Change Password
                                    </button>
                                    <a href="<?= base_url('profile') ?>" class="btn btn-secondary">
                                        <i class="fas fa-times me-1"></i>Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
