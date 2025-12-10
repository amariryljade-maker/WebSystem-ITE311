<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4 text-gray-800">Help Center</h1>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Getting Started
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        New to the platform?
                                    </div>
                                    <a href="<?= base_url('help/faq') ?>" class="btn btn-primary btn-sm mt-2">
                                        Learn More
                                    </a>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-rocket fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        FAQ
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        Common Questions
                                    </div>
                                    <a href="<?= base_url('help/faq') ?>" class="btn btn-success btn-sm mt-2">
                                        View FAQ
                                    </a>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-question-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Contact Support
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        Need Help?
                                    </div>
                                    <a href="<?= base_url('help/contact') ?>" class="btn btn-info btn-sm mt-2">
                                        Contact Us
                                    </a>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-headset fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Quick Links</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>For Students</h5>
                                    <ul class="list-unstyled">
                                        <li><a href="#" class="text-decoration-none">How to enroll in courses</a></li>
                                        <li><a href="#" class="text-decoration-none">Submitting assignments</a></li>
                                        <li><a href="#" class="text-decoration-none">Taking quizzes</a></li>
                                        <li><a href="#" class="text-decoration-none">Viewing grades</a></li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h5>For Teachers</h5>
                                    <ul class="list-unstyled">
                                        <li><a href="#" class="text-decoration-none">Creating courses</a></li>
                                        <li><a href="#" class="text-decoration-none">Managing lessons</a></li>
                                        <li><a href="#" class="text-decoration-none">Grading assignments</a></li>
                                        <li><a href="#" class="text-decoration-none">Student management</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Popular Topics</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <div class="card border-left-warning">
                                        <div class="card-body">
                                            <h6 class="card-title">Account Settings</h6>
                                            <p class="card-text small">Manage your profile, password, and preferences.</p>
                                            <a href="<?= base_url('profile') ?>" class="btn btn-warning btn-sm">Go to Profile</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card border-left-success">
                                        <div class="card-body">
                                            <h6 class="card-title">Course Management</h6>
                                            <p class="card-text small">Create and manage your courses effectively.</p>
                                            <a href="<?= base_url('courses') ?>" class="btn btn-success btn-sm">My Courses</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card border-left-info">
                                        <div class="card-body">
                                            <h6 class="card-title">Notifications</h6>
                                            <p class="card-text small">Stay updated with important announcements.</p>
                                            <a href="<?= base_url('notifications') ?>" class="btn btn-info btn-sm">View Notifications</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card border-left-danger">
                                        <div class="card-body">
                                            <h6 class="card-title">Dashboard</h6>
                                            <p class="card-text small">Access your personalized dashboard.</p>
                                            <a href="<?= base_url('dashboard') ?>" class="btn btn-danger btn-sm">Dashboard</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
