<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-sm-flex align-items-center justify-content-between mb-5">
                <div>
                    <h1 class="h2 page-title mb-2">
                        <i class="bi bi-mortarboard me-3"></i>My Courses
                    </h1>
                    <p class="text-muted mb-0">Continue your learning journey</p>
                </div>
                <div>
                    <a href="<?= site_url('student/enroll_courses') ?>" class="btn btn-modern btn-primary btn-lg">
                        <i class="bi bi-plus-circle me-2"></i>Enroll in Courses
                    </a>
                </div>
            </div>

            <!-- Enhanced Course Search Section -->
            <div class="card card-modern mb-4">
                <div class="card-body p-4">
                    <form id="courseSearchForm">
                        <div class="row g-3">
                            <!-- Search Input -->
                            <div class="col-md-6">
                                <div class="position-relative">
                                    <input type="text" 
                                           class="form-control border-0 bg-light" 
                                           id="courseSearchInput" 
                                           placeholder="Search your courses..."
                                           autocomplete="off">
                                    <i class="bi bi-search position-absolute top-50 end-0 translate-middle-y me-3 text-muted"></i>
                                </div>
                            </div>
                            
                            <!-- Filter Options -->
                            <div class="col-md-3">
                                <select class="form-select border-0 bg-light" id="statusFilter">
                                    <option value="">All Status</option>
                                    <option value="active">Active</option>
                                    <option value="completed">Completed</option>
                                    <option value="in_progress">In Progress</option>
                                </select>
                            </div>
                            
                            <div class="col-md-3">
                                <select class="form-select border-0 bg-light" id="sortByFilter">
                                    <option value="enrolled_desc">Recently Enrolled</option>
                                    <option value="enrolled_asc">Oldest Enrolled</option>
                                    <option value="title_asc">Title A-Z</option>
                                    <option value="title_desc">Title Z-A</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Course Statistics Cards -->
            <div class="row mb-5">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card shadow-lg" style="background: #6c757d;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Enrolled Courses
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= count($enrolled_courses ?? []) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-book fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card text-white shadow-lg" style="background: var(--success-gradient);">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Completed
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        0
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-check-circle fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card text-white shadow-lg" style="background: var(--warning-gradient);">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        In Progress
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= count($enrolled_courses ?? []) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-clock fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card text-white shadow-lg" style="background: var(--info-gradient);">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Certificates
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        0
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-award fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Courses Grid -->
            <div id="coursesContainer">
                <?php if (!empty($enrolled_courses)): ?>
                    <div class="row" id="coursesGrid">
                        <?php foreach ($enrolled_courses as $course): ?>
                            <div class="col-xl-4 col-lg-6 mb-4 course-item" 
                                 data-title="<?= esc(strtolower($course['title'])) ?>"
                                 data-category="<?= esc(strtolower($course['category'] ?? 'general')) ?>"
                                 data-instructor="<?= esc(strtolower($course['instructor_name'] ?? '')) ?>"
                                 data-status="active">
                                <div class="card card-modern h-100">
                                    <!-- Course Header -->
                                    <div class="card-header" style="background: var(--primary-gradient); border: none; color: white; padding: 1.5rem;">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <span class="badge badge-modern bg-light text-dark">
                                                    <i class="bi bi-tag me-1"></i><?= esc($course['category'] ?? 'General') ?>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="badge badge-modern bg-success">
                                                    <i class="bi bi-play-circle me-1"></i>Active
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Course Body -->
                                    <div class="card-body p-4">
                                        <div class="text-center mb-3">
                                            <i class="bi bi-book gradient-icon" style="font-size: 4rem;"></i>
                                        </div>
                                        
                                        <h5 class="card-title text-center mb-3 fw-bold">
                                            <?= esc($course['title']) ?>
                                        </h5>
                                        
                                        <p class="card-text text-muted text-center mb-4">
                                            <?= substr(strip_tags($course['description'] ?? ''), 0, 100) . (strlen(strip_tags($course['description'] ?? '')) > 100 ? '...' : '') ?>
                                        </p>
                                        
                                        <!-- Course Info -->
                                        <div class="row text-center mb-4">
                                            <div class="col-6">
                                                <small class="text-muted">Instructor</small>
                                                <div class="fw-bold"><?= esc($course['instructor_name'] ?? 'N/A') ?></div>
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted">Duration</small>
                                                <div class="fw-bold"><?= esc($course['duration'] ?? 'N/A') ?></div>
                                            </div>
                                        </div>
                                        
                                        <!-- Action Buttons -->
                                        <div class="d-grid gap-2">
                                            <a href="<?= site_url('student/courses/' . $course['course_id'] . '/materials') ?>" 
                                               class="btn btn-modern btn-outline-primary">
                                                <i class="bi bi-journal-text me-2"></i>View Materials
                                            </a>
                                            <div class="btn-group" role="group">
                                                <a href="<?= site_url('student/courses/view/' . $course['course_id']) ?>" 
                                                   class="btn btn-modern btn-outline-info flex-fill">
                                                    <i class="bi bi-eye me-1"></i>View
                                                </a>
                                                <a href="<?= site_url('student/assignments/' . $course['id']) ?>" 
                                                   class="btn btn-modern btn-outline-success flex-fill">
                                                    <i class="bi bi-file-earmark-text me-1"></i>Assignments
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Course Footer -->
                                    <div class="card-footer bg-light border-0">
                                        <small class="text-muted">
                                            <i class="bi bi-calendar3 me-1"></i>
                                            Enrolled: <?= date('M d, Y', strtotime($course['enrolled_at'] ?? 'now')) ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <!-- No Courses State -->
                    <div class="text-center py-5" id="noCoursesMessage">
                        <div class="mb-4">
                            <i class="bi bi-book gradient-icon" style="font-size: 6rem;"></i>
                        </div>
                        <h3 class="text-gray-600 mb-3">No Courses Found</h3>
                        <p class="text-gray-500 mb-4 fs-5">
                            No courses match your search criteria.
                        </p>
                        <div class="d-flex justify-content-center gap-3">
                            <button class="btn btn-modern btn-secondary btn-lg" id="clearSearchBtn">
                                <i class="bi bi-arrow-clockwise me-2"></i>Clear Search
                            </button>
                            <a href="<?= site_url('student/enroll_courses') ?>" class="btn btn-modern btn-primary btn-lg">
                                <i class="bi bi-plus-circle me-2"></i>Browse Courses
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Course search and filtering functionality
    initCourseSearch();
    
    // Auto-hide flash messages after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(function() {
                alert.remove();
            }, 500);
        });
    }, 5000);

    // Enhanced hover effects for course cards
    const courseCards = document.querySelectorAll('.card-modern');
    courseCards.forEach(function(card) {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Stats card hover effects
    const statsCards = document.querySelectorAll('.stats-card');
    statsCards.forEach(function(card) {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    function initCourseSearch() {
        const searchInput = document.getElementById('courseSearchInput');
        const statusFilter = document.getElementById('statusFilter');
        const sortByFilter = document.getElementById('sortByFilter');
        const clearSearchBtn = document.getElementById('clearSearchBtn');
        const courseItems = document.querySelectorAll('.course-item');
        
        if (!searchInput || !courseItems.length) return;

        // Real-time search
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                filterCourses();
            }, 300);
        });

        // Filter changes
        statusFilter.addEventListener('change', filterCourses);
        sortByFilter.addEventListener('change', filterCourses);

        // Clear search
        if (clearSearchBtn) {
            clearSearchBtn.addEventListener('click', function() {
                searchInput.value = '';
                statusFilter.value = '';
                sortByFilter.value = 'enrolled_desc';
                filterCourses();
            });
        }

        function filterCourses() {
            const searchTerm = searchInput.value.toLowerCase();
            const statusValue = statusFilter.value.toLowerCase();
            const sortBy = sortByFilter.value;
            
            let visibleCount = 0;
            const filteredItems = [];

            courseItems.forEach(function(item) {
                const title = item.dataset.title || '';
                const category = item.dataset.category || '';
                const instructor = item.dataset.instructor || '';
                const status = item.dataset.status || '';
                
                // Search filter
                const matchesSearch = searchTerm === '' || 
                    title.includes(searchTerm) || 
                    category.includes(searchTerm) || 
                    instructor.includes(searchTerm);
                
                // Status filter
                const matchesStatus = statusValue === '' || status === statusValue;
                
                // Apply filters
                if (matchesSearch && matchesStatus) {
                    item.style.display = '';
                    filteredItems.push(item);
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            // Sort courses
            sortCourses(filteredItems, sortBy);
            
            // Show/hide no results message
            const noCoursesMessage = document.getElementById('noCoursesMessage');
            const coursesGrid = document.getElementById('coursesGrid');
            
            if (visibleCount === 0) {
                if (noCoursesMessage) noCoursesMessage.style.display = 'block';
                if (coursesGrid) coursesGrid.style.display = 'none';
            } else {
                if (noCoursesMessage) noCoursesMessage.style.display = 'none';
                if (coursesGrid) coursesGrid.style.display = 'flex';
            }
        }

        function sortCourses(items, sortBy) {
            const container = document.getElementById('coursesGrid');
            if (!container) return;

            const sortedItems = Array.from(items).sort(function(a, b) {
                switch(sortBy) {
                    case 'enrolled_asc':
                        return getEnrolledDate(a) - getEnrolledDate(b);
                    case 'enrolled_desc':
                        return getEnrolledDate(b) - getEnrolledDate(a);
                    case 'title_asc':
                        return getTitle(a).localeCompare(getTitle(b));
                    case 'title_desc':
                        return getTitle(b).localeCompare(getTitle(a));
                    default:
                        return 0;
                }
            });

            // Reorder DOM elements
            sortedItems.forEach(function(item) {
                container.appendChild(item);
            });
        }

        function getEnrolledDate(item) {
            const footer = item.querySelector('.card-footer small');
            if (footer) {
                const text = footer.textContent;
                const dateMatch = text.match(/Enrolled: (\w{3} \d{2}, \d{4})/);
                if (dateMatch) {
                    return new Date(dateMatch[1]);
                }
            }
            return new Date(0);
        }

        function getTitle(item) {
            const titleElement = item.querySelector('.card-title');
            return titleElement ? titleElement.textContent.trim() : '';
        }
    }
});
</script>
<?= $this->endSection() ?>

                <div class="col-md-3">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        In Progress
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= count($enrolled_courses) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-spinner fa-2x text-gray-300"></i>
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
                                        Available
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= count($available_courses) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-plus-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enrolled Courses -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">My Enrolled Courses</h6>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($enrolled_courses)): ?>
                                <div class="row">
                                    <?php foreach ($enrolled_courses as $course): ?>
                                        <div class="col-md-4 mb-4">
                                            <div class="card h-100">
                                                <?php if ($course['thumbnail']): ?>
                                                    <img src="<?= base_url($course['thumbnail']) ?>" class="card-img-top" alt="<?= esc($course['title']) ?>" style="height: 200px; object-fit: cover;">
                                                <?php else: ?>
                                                    <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height: 200px;">
                                                        <i class="fas fa-book fa-3x text-muted"></i>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="card-body">
                                                    <h5 class="card-title"><?= esc($course['title']) ?></h5>
                                                    <p class="card-text text-muted small">
                                                        <?= strlen(strip_tags($course['description'])) > 100 ? substr(strip_tags($course['description']), 0, 100) . '...' : strip_tags($course['description']) ?>
                                                    </p>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <small class="text-muted">Instructor: <?= esc($course['instructor_name'] ?? 'N/A') ?></small>
                                                        <div class="progress" style="height: 10px; width: 100px;">
                                                            <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <a href="<?= site_url('/student/courses/view/' . $course['course_id']) ?>" class="btn btn-primary btn-sm">View Course</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <p class="text-muted">You haven't enrolled in any courses yet. Browse available courses below.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Available Courses -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Available Courses</h6>
                            <a href="<?= site_url('/student/courses/enroll') ?>" class="btn btn-success btn-sm">
                                <i class="fas fa-plus me-1"></i>Browse All
                            </a>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($available_courses)): ?>
                                <div class="row">
                                    <?php foreach (array_slice($available_courses, 0, 6) as $course): ?>
                                        <div class="col-md-4 mb-4">
                                            <div class="card h-100">
                                                <?php if ($course['thumbnail']): ?>
                                                    <img src="<?= base_url($course['thumbnail']) ?>" class="card-img-top" alt="<?= esc($course['title']) ?>" style="height: 200px; object-fit: cover;">
                                                <?php else: ?>
                                                    <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height: 200px;">
                                                        <i class="fas fa-book fa-3x text-muted"></i>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="card-body">
                                                    <h5 class="card-title"><?= esc($course['title']) ?></h5>
                                                    <p class="card-text text-muted small">
                                                        <?= strlen(strip_tags($course['description'])) > 100 ? substr(strip_tags($course['description']), 0, 100) . '...' : strip_tags($course['description']) ?>
                                                    </p>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <small class="text-muted">Instructor: <?= esc($course['instructor_name'] ?? 'N/A') ?></small>
                                                        <span class="badge bg-info"><?= esc($course['category'] ?? 'General') ?></span>
                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <a href="<?= site_url('/student/courses/view/' . $course['id']) ?>" class="btn btn-outline-primary btn-sm">View Details</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php if (count($available_courses) > 6): ?>
                                    <div class="text-center mt-3">
                                        <a href="<?= site_url('/student/courses/enroll') ?>" class="btn btn-primary">View All Available Courses</a>
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <p class="text-muted">No available courses at the moment.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
