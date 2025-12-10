<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Edit Profile</h1>
                <a href="<?= base_url('profile') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Back to Profile
                </a>
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
                            <h6 class="m-0 font-weight-bold text-primary">Edit Profile Information</h6>
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

                            <form action="<?= base_url('profile/edit') ?>" method="post">
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="name">Full Name *</label>
                                            <input type="text" class="form-control" id="name" name="name" 
                                                   value="<?= old('name') ?: esc($user['name']) ?>" required>
                                            <?php if ($validation->getError('name')): ?>
                                                <div class="text-danger"><?= $validation->getError('name') ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="email">Email Address *</label>
                                            <input type="email" class="form-control" id="email" name="email" 
                                                   value="<?= old('email') ?: esc($user['email']) ?>" required>
                                            <?php if ($validation->getError('email')): ?>
                                                <div class="text-danger"><?= $validation->getError('email') ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i>Update Profile
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
