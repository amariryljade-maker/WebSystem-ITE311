<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4 text-gray-800">System Settings</h1>

            <?php if (session()->has('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->has('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- General Settings -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">General Settings</h6>
                </div>
                <div class="card-body">
                    <form action="<?= site_url('/admin/settings') ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="site_name" class="form-label">Site Name</label>
                                    <input type="text" class="form-control" id="site_name" name="site_name" value="ITE311-AMAR LMS">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="site_email" class="form-label">Site Email</label>
                                    <input type="email" class="form-control" id="site_email" name="site_email" value="admin@ite311-amar.com">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="site_description" class="form-label">Site Description</label>
                                    <textarea class="form-control" id="site_description" name="site_description" rows="3">Learning Management System for ITE311</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="timezone" class="form-label">Timezone</label>
                                    <select class="form-select" id="timezone" name="timezone">
                                        <option value="UTC" selected>UTC</option>
                                        <option value="Asia/Manila">Asia/Manila</option>
                                        <option value="America/New_York">America/New_York</option>
                                        <option value="Europe/London">Europe/London</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="language" class="form-label">Default Language</label>
                                    <select class="form-select" id="language" name="language">
                                        <option value="en" selected>English</option>
                                        <option value="es">Spanish</option>
                                        <option value="fr">French</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="maintenance_mode" class="form-label">Maintenance Mode</label>
                                    <select class="form-select" id="maintenance_mode" name="maintenance_mode">
                                        <option value="0" selected>Disabled</option>
                                        <option value="1">Enabled</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Save Settings</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Email Settings -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Email Settings</h6>
                </div>
                <div class="card-body">
                    <form action="<?= site_url('/admin/settings') ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email_protocol" class="form-label">Email Protocol</label>
                                    <select class="form-select" id="email_protocol" name="email_protocol">
                                        <option value="mail" selected>PHP Mail</option>
                                        <option value="smtp">SMTP</option>
                                        <option value="sendmail">Sendmail</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="smtp_host" class="form-label">SMTP Host</label>
                                    <input type="text" class="form-control" id="smtp_host" name="smtp_host" placeholder="smtp.example.com">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="smtp_port" class="form-label">SMTP Port</label>
                                    <input type="number" class="form-control" id="smtp_port" name="smtp_port" value="587">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="smtp_username" class="form-label">SMTP Username</label>
                                    <input type="text" class="form-control" id="smtp_username" name="smtp_username">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="smtp_password" class="form-label">SMTP Password</label>
                                    <input type="password" class="form-control" id="smtp_password" name="smtp_password">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Save Email Settings</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Security Settings -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Security Settings</h6>
                </div>
                <div class="card-body">
                    <form action="<?= site_url('/admin/settings') ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="session_timeout" class="form-label">Session Timeout (minutes)</label>
                                    <input type="number" class="form-control" id="session_timeout" name="session_timeout" value="30">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="max_login_attempts" class="form-label">Max Login Attempts</label>
                                    <input type="number" class="form-control" id="max_login_attempts" name="max_login_attempts" value="5">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="force_https" name="force_https">
                                    <label class="form-check-label" for="force_https">
                                        Force HTTPS
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="enable_captcha" name="enable_captcha">
                                    <label class="form-check-label" for="enable_captcha">
                                        Enable CAPTCHA
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Save Security Settings</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- System Information -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">System Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Server Information</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td>PHP Version:</td>
                                    <td><?= PHP_VERSION ?></td>
                                </tr>
                                <tr>
                                    <td>CodeIgniter Version:</td>
                                    <td>4.4.8</td>
                                </tr>
                                <tr>
                                    <td>Server Software:</td>
                                    <td><?= $_SERVER['SERVER_SOFTWARE'] ?? 'N/A' ?></td>
                                </tr>
                                <tr>
                                    <td>Database:</td>
                                    <td>MySQL</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6>System Status</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td>Application Status:</td>
                                    <td><span class="badge bg-success">Online</span></td>
                                </tr>
                                <tr>
                                    <td>Database Connection:</td>
                                    <td><span class="badge bg-success">Connected</span></td>
                                </tr>
                                <tr>
                                    <td>Last Backup:</td>
                                    <td>N/A</td>
                                </tr>
                                <tr>
                                    <td>Disk Usage:</td>
                                    <td>N/A</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
