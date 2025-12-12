<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'My Courses' ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background-color: #f8f9fc;
            padding-top: 20px;
        }
        .card {
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            border: 1px solid #e3e6f0;
        }
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #e3e6f0;
        }
        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }
        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2653d4;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0 text-gray-800">My Courses</h1>
                    <a href="<?= base_url('instructor/courses/create') ?>" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Create New Course
                    </a>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Courses Overview</h6>
                    </div>
                    <div class="card-body p-0">
                        <?php if (empty($courses)): ?>
                            <div class="p-4 text-center text-muted">
                                <i class="fas fa-graduation-cap fa-3x mb-3"></i>
                                <p>No courses found. Create your first course!</p>
                                <a href="<?= base_url('instructor/courses/create') ?>" class="btn btn-primary">
                                    <i class="fas fa-plus me-1"></i>Create Course
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Course Title</th>
                                            <th>Category</th>
                                            <th>Status</th>
                                            <th>Created</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($courses as $course): ?>
                                            <tr>
                                                <td>
                                                    <strong><?= esc($course['title']) ?></strong>
                                                    <br>
                                                    <small class="text-muted"><?= esc($course['description']) ?></small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info"><?= esc($course['category']) ?></span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-<?= $course['is_published'] ? 'success' : 'warning' ?>">
                                                        <?= $course['is_published'] ? 'Published' : 'Draft' ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <small><?= date('M j, Y', strtotime($course['created_at'])) ?></small>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="<?= base_url('instructor/courses/view/' . $course['id']) ?>" 
                                                           class="btn btn-outline-info" title="View">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="<?= base_url('instructor/courses/edit/' . $course['id']) ?>" 
                                                           class="btn btn-outline-primary" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button class="btn btn-outline-danger" 
                                                                onclick="confirmDelete(<?= $course['id'] ?>)" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
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

    <script>
    function confirmDelete(courseId) {
        if (confirm('Are you sure you want to delete this course?')) {
            window.location.href = '<?= base_url('instructor/courses/delete/') ?>' + courseId;
        }
    }
    </script>
</body>
</html>
