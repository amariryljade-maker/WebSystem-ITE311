<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Enrollment System Test</h1>
        
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>Database Connection Test</h3>
                    </div>
                    <div class="card-body">
                        <button onclick="testDatabaseConnection()" class="btn btn-primary">Test Database Connection</button>
                        <div id="dbResult" class="mt-3"></div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>Enrollment Table Test</h3>
                    </div>
                    <div class="card-body">
                        <button onclick="testEnrollmentTable()" class="btn btn-info">Check Enrollment Table</button>
                        <div id="tableResult" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Test Enrollment</h3>
                    </div>
                    <div class="card-body">
                        <form id="testEnrollmentForm">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="userId">User ID:</label>
                                    <input type="number" id="userId" name="user_id" class="form-control" value="1" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="courseId">Course ID:</label>
                                    <input type="number" id="courseId" name="course_id" class="form-control" value="1" required>
                                </div>
                                <div class="col-md-3">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-success">Test Enrollment</button>
                                </div>
                                <div class="col-md-3">
                                    <label>&nbsp;</label>
                                    <button type="button" onclick="checkExistingEnrollment()" class="btn btn-warning">Check Existing</button>
                                </div>
                            </div>
                        </form>
                        <div id="enrollmentResult" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Current Enrollments</h3>
                    </div>
                    <div class="card-body">
                        <button onclick="showCurrentEnrollments()" class="btn btn-info">Show All Enrollments</button>
                        <div id="currentEnrollments" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function testDatabaseConnection() {
            fetch('<?= base_url("student/test-db") ?>')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('dbResult').innerHTML = 
                        `<div class="alert alert-${data.success ? 'success' : 'danger'}">
                            ${data.message}
                        </div>`;
                })
                .catch(error => {
                    document.getElementById('dbResult').innerHTML = 
                        `<div class="alert alert-danger">Error: ${error.message}</div>`;
                });
        }

        function testEnrollmentTable() {
            fetch('<?= base_url("student/test-table") ?>')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('tableResult').innerHTML = 
                        `<div class="alert alert-${data.success ? 'success' : 'danger'}">
                            ${data.message}
                            ${data.table_structure ? '<pre>' + data.table_structure + '</pre>' : ''}
                        </div>`;
                })
                .catch(error => {
                    document.getElementById('tableResult').innerHTML = 
                        `<div class="alert alert-danger">Error: ${error.message}</div>`;
                });
        }

        function checkExistingEnrollment() {
            const userId = document.getElementById('userId').value;
            const courseId = document.getElementById('courseId').value;
            
            fetch(`<?= base_url("student/check-enrollment") ?>?user_id=${userId}&course_id=${courseId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('enrollmentResult').innerHTML = 
                        `<div class="alert alert-${data.success ? 'info' : 'danger'}">
                            ${data.message}
                        </div>`;
                })
                .catch(error => {
                    document.getElementById('enrollmentResult').innerHTML = 
                        `<div class="alert alert-danger">Error: ${error.message}</div>`;
                });
        }

        function showCurrentEnrollments() {
            fetch('<?= base_url("student/show-enrollments") ?>')
                .then(response => response.json())
                .then(data => {
                    let html = '<div class="table-responsive"><table class="table table-striped"><thead><tr><th>ID</th><th>User ID</th><th>Course ID</th><th>Enrollment Date</th><th>Status</th></tr></thead><tbody>';
                    
                    if (data.enrollments && data.enrollments.length > 0) {
                        data.enrollments.forEach(enrollment => {
                            html += `<tr>
                                <td>${enrollment.id}</td>
                                <td>${enrollment.user_id}</td>
                                <td>${enrollment.course_id}</td>
                                <td>${enrollment.enrollment_date}</td>
                                <td><span class="badge bg-${enrollment.status === 'active' ? 'success' : enrollment.status === 'completed' ? 'info' : 'warning'}">${enrollment.status}</span></td>
                            </tr>`;
                        });
                    } else {
                        html += '<tr><td colspan="5" class="text-center">No enrollments found</td></tr>';
                    }
                    
                    html += '</tbody></table></div>';
                    document.getElementById('currentEnrollments').innerHTML = html;
                })
                .catch(error => {
                    document.getElementById('currentEnrollments').innerHTML = 
                        `<div class="alert alert-danger">Error: ${error.message}</div>`;
                });
        }

        document.getElementById('testEnrollmentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('<?= base_url("student/test-enrollment") ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('enrollmentResult').innerHTML = 
                    `<div class="alert alert-${data.success ? 'success' : 'danger'}">
                        ${data.message}
                    </div>`;
                    
                if (data.success) {
                    showCurrentEnrollments();
                }
            })
            .catch(error => {
                document.getElementById('enrollmentResult').innerHTML = 
                    `<div class="alert alert-danger">Error: ${error.message}</div>`;
            });
        });
    </script>
</body>
</html>
