<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">My Students</h1>
                <div>
                    <button class="btn btn-outline-primary me-2" onclick="exportStudents()">
                        <i class="fas fa-download me-1"></i>Export
                    </button>
                    <button class="btn btn-primary" onclick="addStudent()">
                        <i class="fas fa-user-plus me-1"></i>Add Student
                    </button>
                </div>
            </div>

            <!-- Student Statistics -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card border-left-primary shadow h-100 py-2" style="background: gray;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Students
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= count($students) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Active Students
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        0
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user-check fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Average Grade
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        N/A
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Completion Rate
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        0%
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-percentage fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Students List</h6>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($students)): ?>
                        <div class="p-4 text-center text-muted">
                            <i class="fas fa-user-graduate fa-3x mb-3"></i>
                            <p>No students found. Students will appear here when they enroll in your courses.</p>
                            <button class="btn btn-primary" onclick="addStudent()">
                                <i class="fas fa-user-plus me-1"></i>Add Student Manually
                            </button>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Student</th>
                                        <th>Email</th>
                                        <th>Enrolled Courses</th>
                                        <th>Average Grade</th>
                                        <th>Last Activity</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($students as $student): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" 
                                                         style="width: 40px; height: 40px;">
                                                        <?= substr($student['name'], 0, 2) ?>
                                                    </div>
                                                    <div>
                                                        <strong><?= esc($student['name']) ?></strong>
                                                        <br>
                                                        <small class="text-muted">ID: <?= $student['id'] ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="mailto:<?= esc($student['email']) ?>" class="text-decoration-none">
                                                    <?= esc($student['email']) ?>
                                                </a>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">
                                                    <?= $student['course_count'] ?? 0 ?> courses
                                                </span>
                                            </td>
                                            <td>
                                                <?php if (isset($student['average_grade'])): ?>
                                                    <span class="badge bg-<?= $student['average_grade'] >= 80 ? 'success' : ($student['average_grade'] >= 60 ? 'warning' : 'danger') ?>">
                                                        <?= number_format($student['average_grade'], 1) ?>%
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted">N/A</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if (isset($student['last_activity'])): ?>
                                                    <small><?= date('M j, Y H:i', strtotime($student['last_activity'])) ?></small>
                                                <?php else: ?>
                                                    <span class="text-muted">Never</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?= $student['is_active'] ? 'success' : 'secondary' ?>">
                                                    <?= $student['is_active'] ? 'Active' : 'Inactive' ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-outline-info" 
                                                            onclick="viewStudent(<?= $student['id'] ?>)" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button class="btn btn-outline-primary" 
                                                            onclick="messageStudent(<?= $student['id'] ?>)" title="Message">
                                                        <i class="fas fa-envelope"></i>
                                                    </button>
                                                    <button class="btn btn-outline-success" 
                                                            onclick="viewGrades(<?= $student['id'] ?>)" title="Grades">
                                                        <i class="fas fa-chart-bar"></i>
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
function addStudent() {
    // Add student functionality
    console.log('Add student');
    alert('Add student functionality will be implemented here.');
}

function exportStudents() {
    // Export students functionality
    console.log('Export students');
    alert('Export students functionality will be implemented here.');
}

function viewStudent(studentId) {
    // View student details
    console.log('View student:', studentId);
    alert('View student details functionality will be implemented here.');
}

function messageStudent(studentId) {
    // Message student
    console.log('Message student:', studentId);
    alert('Message student functionality will be implemented here.');
}

function viewGrades(studentId) {
    // View student grades
    console.log('View grades:', studentId);
    alert('View grades functionality will be implemented here.');
}
</script>

<?= $this->endSection() ?>
