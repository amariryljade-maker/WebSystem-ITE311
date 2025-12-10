<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Contact Us</h1>
                <a href="<?= base_url('help') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Back to Help
                </a>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Send us a Message</h6>
                        </div>
                        <div class="card-body">
                            <?php if (session()->getFlashdata('success')): ?>
                                <div class="alert alert-success">
                                    <?= session()->getFlashdata('success') ?>
                                </div>
                            <?php endif; ?>

                            <form action="<?= base_url('help/contact') ?>" method="post">
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="name">Your Name *</label>
                                            <input type="text" class="form-control" id="name" name="name" 
                                                   value="<?= old('name') ?>" required>
                                            <?php if ($validation->getError('name')): ?>
                                                <div class="text-danger"><?= $validation->getError('name') ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="email">Email Address *</label>
                                            <input type="email" class="form-control" id="email" name="email" 
                                                   value="<?= old('email') ?>" required>
                                            <?php if ($validation->getError('email')): ?>
                                                <div class="text-danger"><?= $validation->getError('email') ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="subject">Subject *</label>
                                    <input type="text" class="form-control" id="subject" name="subject" 
                                           value="<?= old('subject') ?>" required>
                                    <?php if ($validation->getError('subject')): ?>
                                        <div class="text-danger"><?= $validation->getError('subject') ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="message">Message *</label>
                                    <textarea class="form-control" id="message" name="message" rows="6" required><?= old('message') ?></textarea>
                                    <?php if ($validation->getError('message')): ?>
                                        <div class="text-danger"><?= $validation->getError('message') ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane me-1"></i>Send Message
                                    </button>
                                    <a href="<?= base_url('help') ?>" class="btn btn-secondary">
                                        <i class="fas fa-times me-1"></i>Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Contact Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <h6><i class="fas fa-envelope me-2"></i>Email Support</h6>
                                <p class="text-muted">support@lms-amar.com</p>
                                <small class="text-muted">We'll respond within 24 hours</small>
                            </div>
                            
                            <div class="mb-3">
                                <h6><i class="fas fa-phone me-2"></i>Phone Support</h6>
                                <p class="text-muted">+1 (555) 123-4567</p>
                                <small class="text-muted">Mon-Fri, 9AM-5PM EST</small>
                            </div>
                            
                            <div class="mb-3">
                                <h6><i class="fas fa-clock me-2"></i>Response Time</h6>
                                <p class="text-muted">Email: 24 hours</p>
                                <p class="text-muted">Phone: Immediate during business hours</p>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Other Resources</h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <a href="<?= base_url('help/faq') ?>" class="text-decoration-none">
                                        <i class="fas fa-question-circle me-2"></i>Frequently Asked Questions
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="<?= base_url('help') ?>" class="text-decoration-none">
                                        <i class="fas fa-book me-2"></i>User Guide
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="#" class="text-decoration-none">
                                        <i class="fas fa-video me-2"></i>Video Tutorials
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="#" class="text-decoration-none">
                                        <i class="fas fa-comments me-2"></i>Community Forum
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
